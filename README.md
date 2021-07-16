# Remove Duplicate Product images in Magento 2

This Extension allows you to find duplicate product images from your product list and from this list you can easily remove them by running a command.


**IMPORTANT:** *Remove Duplicate Product Images is really used for people who importing product data and running the same import process over and over, Suppose If some products import fail and you aren’t sure exactly which ones so you run the product import process again but this process duplicates the product images and It’s very difficult task to find which product has duplicate images.*

**IMPORTANT:** *To remove this type of headache and to save your huge amount of server space we have developed this splendid extension, after installing this extension you have to just run command "php bin/magento duplicate:remove" and it will removed all duplicate product images.*

**IMPORTANT:** *if you like the extension, could you please add a star to this GitHub repository in the top right corner. This is really important for us. Thanks.*

## Installation

### Using Composer (recommended)
1) Go to your Magento root folder
2) Downaload the extension using composer:
    ```
    composer require magegadgets/magento2-product-duplicate-images-remove
    ```
3) Run setup commands:

    ```
    php bin/magento setup:upgrade;
    php bin/magento setup:di:compile;
    php bin/magento setup:static-content:deploy -f;
    php bin/magento duplicate:remove;
    ```
   
### Manually
1) Go to your Magento root folder:
    
    ```
    cd <magento_root>
    ```
   
2) Copy extension files to *app/code/Magegadgets/RemoveDuplicateImage* folder:
    ```
    git clone https://github.com/magegadgets/magento2-product-duplicate-images-remove.git app/code/MagestyApps/WebImages
    ```
    ***NOTE:*** *alternatively, you can manually create the folder and copy the extension files there.*
    
3) Run setup commands:

    ```
    php bin/magento setup:upgrade;
    php bin/magento setup:di:compile;
    php bin/magento setup:static-content:deploy -f;
    php bin/magento duplicate:remove;
    
## Other Extensions
You can find more useful extensions for Magento 2 by visiting [Magegadgets Official Website](https://www.magegadgets.com/)
    ```
