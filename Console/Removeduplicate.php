<?php
namespace Magegadgets\RemoveDuplicateImage\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Removeduplicate extends Command
{
   protected function configure()
   {
       $this->setName('duplicate:remove');
       $this->setDescription('Demo command line');
       
       parent::configure();
   }
   protected function execute(InputInterface $input, OutputInterface $output)
   {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $app_state = $objectManager->get('\Magento\Framework\App\State');
        $app_state->setAreaCode('global');
        ini_set('memory_limit','10240M');
        ini_set('max_execution_time', 0); 
        set_time_limit(0);
        $mediaApi = $objectManager->create('\Magento\Catalog\Model\Product\Gallery\Processor');
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $storeManager->setCurrentStore(0);
        $mediaUrl = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $directoryList=$objectManager->get('\Magento\Framework\App\Filesystem\DirectoryList');
        $path = $directoryList->getPath('media'); 
        $productCollection=$objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
        $_products = $productCollection->addAttributeToSelect('*')->load();

        $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
        $i =0;
        $total = count($_products);
        $count = 0;
        $productCount = array();
        foreach($_products as $_prod) {
            $_product = $productRepository->getById($_prod->getId());
            $_product->setStoreId(0);
            $_md5_values = array();
            $base_image = $_product->getImage();
            
            if($base_image != 'no_selection') {
                $mediaUrl = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                $filepath = $path.'/catalog/product' . $base_image ;
                if (file_exists($filepath) && is_file($filepath)) {
                    $_md5_values[] = md5(file_get_contents($filepath));            
                }
                $i++;

                echo "\r\n processing product $i of $total ";
                // Loop through product images
                $gallery = $_product->getMediaGalleryEntries();
                if ($gallery) {
                    foreach ($gallery as $key => $galleryImage) {
                        //protected base image
                        if($galleryImage->getFile() == $base_image) {
                            continue;
                        }
                        $filepath = $path.'/catalog/product' .$galleryImage->getFile();

                        if(file_exists($filepath)) {
                            $md5 = md5(file_get_contents($filepath));
                        } else {
                            continue;
                        }

                        if( in_array( $md5, $_md5_values )) {
                            if (count($galleryImage->getTypes()) > 0) {
                                continue;
                            }
                            unset($gallery[$key]);
                            echo "\r\n removed duplicate image from ".$_product->getSku();
                            $count++;
                        } else {
                            $_md5_values[] = $md5;
                        }
                    }
                    
                    $_product->setMediaGalleryEntries($gallery);
                    $productRepository->save($_product);            
                }
                //$_product->save();
            }
            }

               $output->writeln("\r\n Duplicate Images are Removed");
           }
}
