# BRAND Module(Create/Edit/Delete via Rest API)

This module provides the create/edit/manage functionality for Brands(through **Rest API**).

**File Structure:**

```
Magento
`-- Brand
    |-- Api
    |   |-- BrandManagementInterface.php
    |   |-- BrandRepositoryInterface.php
    |   `-- Data
    |       |-- BrandInterface.php
    |       |-- BrandManagementDataInterface.php
    |       `-- BrandSearchResultsInterface.php
    |-- Model
    |   |-- Brand.php
    |   |-- BrandManagement.php
    |   |-- BrandRepository.php
    |   |-- Data
    |   |   |-- Brand.php
    |   |   `-- BrandManagementData.php
    |   |-- ResourceModel
    |   |   |-- Brand
    |   |   |   `-- Collection.php
    |   |   `-- Brand.php
    |   `-- SearchResults.php
    |-- README.md
    |-- composer.json
    |-- etc
    |   |-- acl.xml
    |   |-- db_schema.xml
    |   |-- db_schema_whitelist.json
    |   |-- di.xml
    |   |-- module.xml
    |   `-- webapi.xml
    `-- registration.php
```

1. module.xml: The configuration for a module. This file also contains the sequence element that determines the module load order.
   
   ```
   Class: Magento\Framework\Component\ComponentRegistrar, method - register()
   
   ComponentRegistrar::register(ComponentRegistrar::MODULE, 'Magento_Brand',__DIR__);
   ```
   
2. config.xml: Specifies the default configuration value.

   
3. adminhtml/system.xml: new store configuration fields are set up.

   
4. Declarative schema:
   
    1. db_schema.xml: This file declares a module’s database structure ( ref:- https://devdocs.magento.com/guides/v2.4/extension-dev-guide/declarative-schema/db-schema.html )
   
    2. Create a schema whitelist:
      * File provides a history of all tables, columns, and keys added with declarative schema. As a best practice, you should generate a new whitelist file.
      * cmd:- php bin/magento setup:db-declaration:generate-whitelist --module-name=Magento_Brand

   ```
   CREATE TABLE `mdc_band` (
    `brand_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'Brand ID',
    `name` varchar(255) NOT NULL COMMENT 'Brand Title',
    `code` varchar(255) NOT NULL COMMENT 'Brand Identifier',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Brand Creation Time',
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Brand Modification Time',
    PRIMARY KEY (`brand_id`),
    UNIQUE KEY `MDC_BAND_CODE` (`code`),
    FULLTEXT KEY `MDC_BAND_NAME_CODE` (`name`,`code`)
    ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='MDC Brand Table'

    Table: mdc_band
    +------------+--------------+------+-----+---------------------+-------------------------------+
    | Field      | Type         | Null | Key | Default             | Extra                         |
    +------------+--------------+------+-----+---------------------+-------------------------------+
    | brand_id   | smallint(6)  | NO   | PRI | NULL                | auto_increment                |
    | name       | varchar(255) | NO   | MUL | NULL                |                               |
    | code       | varchar(255) | NO   | UNI | NULL                |                               |
    | created_at | timestamp    | NO   |     | current_timestamp() |                               |
    | updated_at | timestamp    | NO   |     | current_timestamp() | on update current_timestamp() |
    +------------+--------------+------+-----+---------------------+-------------------------------+
   ```
   
5. Model: Models represent a row of data from the database. Each row, whether it is loaded through a collection or a resource model. 
   
    * Custom models typically extend \Magento\Framework\Model\AbstractModel
    * Models that need extension attributes which extend \Magento\Framework\Model\AbstractExtensibleModel
    

6. ResourceModel: The resource model is what communicates with the database(put most custom queries here).
   
    * Resource models extend: \Magento\Framework\Model\ResourceModel\Db\AbstractDb
    

7. Collections: A collection loads multiple entities from the database.
   
   * One advantage of a collection over a repository for EAV entities is that you can specify what data is loaded in a collection.
   * As such, for EAV entities, a collection represents a much faster way to load data. For the API, this really doesn’t matter, and a repository is better suited.
   * Collections extend: \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
    
    
8. Repositories: Repositories are a combination of resource model and collections.
   
   * No abstract repository classes.
   * To available on frontend, repositories must implement a service contract(stored in /API directory). 
    
  To create a repository:

     * Build a service contract interface(store in /API directory) for the repository.

     * Create a Repository model which implements the service contract.

     * Create a interface to make \Magento\Framework\Api\SearchResultsInterface for getList Method.

     * Inject 
        * Model
        * Resource Model
        * Collection.

9. SearchCriteria:

    * New way to locate records (SearchCriteriaInterface).
    * Create a interface to make \Magento\Framework\Api\SearchResultsInterface for getList Method.
    

10. To enable the repository to be accessed via an API, you must:

   
       • Create etc/webapi.xml
    
            * API routes and endpoints are defined in etc/webapi.xml.
    
            * APIs rely on service contracts. The types must be clearly specified in the docblock.
    
            * API configuration is saved in the cache: any updates to etc/webapi.xml require a refresh of the config_webservice cache.
    
            * APIs do not allow you to set cookies. If this is required (like logging a user in), you must use a controller, which can be accompanied by a JSON response.

       • Create etc/acl.xml (if it is necessary to restrict access to the API calls)
        
            * You can restrict access with the <resources/> node:
                • <resource ref="anonymous"/>: anyone can access.
    
                • <resource ref="self"/>: authenticated by the session. At this point,
                only the frontend session works with this.
    
                • <resource ref="Chapter3_Database::discounts"/>:
                authenticated with the admin ACL.

Testing with swagger/Postman:
    
    PostMan: 

    1. Create API 
        * Method: POST
        * URL: {{base_url}}/rest/V1/brand/create/
        * Provide Bearer token from admin(Integration token)
        * Request: 
            {
                "brandData": {
                    "items": [
                        {
                        "name": "Brand Name",
                        "code" : "brand_code"
                        }
                    ]
                }
           }
        
        * o/p:
        Table: mdc_band;
        +----------+------------+------------+---------------------+---------------------+
        | brand_id | name       | code       | created_at          | updated_at          |
        +----------+------------+------------+---------------------+---------------------+
        |        1 | Brand Name | brand_code | 2021-06-06 15:47:38 | 2021-06-06 15:47:38 |
        +----------+------------+------------+---------------------+---------------------+
    
    2. Update API:
        * Method: PUT
        * URL: {{base_url}}/rest/V1/brand/create/
        * Provide Bearer token from admin(Integration token)
        * Request: 
            {
                "brandData": {
                    "items": [
                        {
                        "name": "Brand Name - Update",
                        "code" : "brand_code"
                        }
                    ]
                }
           }
        * o/p:
        Table: mdc_band;
        +----------+---------------------+------------+---------------------+---------------------+
        | brand_id | name                | code       | created_at          | updated_at          |
        +----------+---------------------+------------+---------------------+---------------------+
        |        1 | Brand Name - Update | brand_code | 2021-06-06 15:47:38 | 2021-06-06 15:50:06 |
        +----------+---------------------+------------+---------------------+---------------------+
    
    3. Update API:
        * Method: DELETE
        * URL: {{base_url}}/rest/V1/brand/brand_code
        * Provide Bearer token from admin(system > Integration page > token)
        * o/p:
        Table: mdc_band;
        Empty set (0.000 sec)        
    
    Swagger URL: {{base_url}}/swagger
            
