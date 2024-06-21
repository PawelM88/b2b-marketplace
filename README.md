# Spryker assets

This repository is a collection of my work and learning on Spryker e-commerce. Each branch is a separate asset.
Documentation is included for almost all assets.

## Assets in branches

### <h3 style="color: #B8860B;">feature/1-Remove_no_file_doc_block</h3>

The asset that contains documentation on how to disable sample rule when using static code analysis

```bash
console code:sniff:style -m ModuleName
```

The disabled rule is `FileDocBlock` in the `phpcs.xml` file

### <h3 style="color: #B8860B;">feature/2-Remove_constructor_property_promotion_is_disallowed</h3>

As in `1-Remove_no_file_doc_block` branch, this asset disables the rule. This time it
is `DisallowConstructorPropertyPromotion`

### <h3 style="color: #1E90FF;">feature/3-Automatic_creation_of_company_roles</h3>

The asset retrieves data about the company from the `company.csv` file and creates roles with permissions for each
existing company based on what is included in the `CompanyRoleConfig class`.

### <h3 style="color: #1E90FF;">feature/4-Automatic_email_verification</h3>

The asset is turning off the email verification of newly created user. User is set as verified from the start

### <h3 style="color: #1E90FF;">feature/5-Enrich_merchant_with_payment_specific_attributes_per_store</h3>

The asset that adds a new attribute to merchants. It is imported from a csv file. There is a new tab in the Back Office
in the merchant creation and editing form.<br>
Because the task concerns, among others, displaying values by store. There must be several fields on the form to fill
in - each for a different store. However, Twig has a protection that prevents the same field from being rendered
multiple times.<br>
The next necessary step was to place several forms inside one another.

### <h3 style="color: #3CB371;">feature/6-Order_details_email_notifications_process</h3>

The asset is sending emails notification. The user should receive an email: 
- placing a new order
- payment confirmation
- shipping order
- order cancellation
- emails content should be customized by Client
- the email templates can be edited inside the Back office in a CMS Block and are available as HTML and text versions.

### <h3 style="color: #3CB371;">feature/7-Build_contact_form</h3>

As the name suggests, asset creates a contact form which is on every merchant's profile site. Contact form contains `name`, `phone number`, `e-mail`, `subject` and `message box`.

### <h3 style="color: #F0E68C;">feature/8-CMS_page_content_for_api</h3>

The asset is adding 2 more properties (`content` and `metaTitle`.) to the `RestCmsPagesAttributesTransfer` for `cms-pages/{cmPageId}` endpoint. 

### <h3 style="color: #F0E68C;">feature/9-Content_items_for_API</h3>

The asset is creating a completely new endpoint, which allows retrieving information about specific content item based on its key.

### <h3 style="color: #B8860B;">feature/10-How_to_implement_molecule_and_widget</h3>

Documentation how to implement molecule and widget

### <h3 style="color: #1E90FF;">feature/11-Import_middleware_json</h3>

The asset is introducing how to create MiddlewareProcessor for `.json` file.

### <h3 style="color: #1E90FF;">feature/12-Import_middleware_xml</h3>

As in `feature/11-Import_middleware_json` branch, but for `xml` file.

#### <h3 style="color: #3CB371;">feature/13-Request_to_external_system_from_zed_layer</h3>

The asset is connecting with external system and get data from it. URL for external system is in `config_default.php`

### <h3 style="color: #1E90FF;">feature/14-Setup_a_new_default_store</h3>

The asset is modify the most important file to create a new store (`Australia`). Please note that not all csv files have been changed. When creating a new store, you need to modify almost all csv files for import data.

### <h3 style="color: #1E90FF;">feature/15-Customers_import_via_zed_using_csv_file</h3>

The asset creates new functionality to import customers from csv file with their connections to companies, company business units, company unit addresses and company users. File is validating and then data is put into tables.

### <h3 style="color: #1E90FF;">feature/16-Terms_and_conditions_customisation</h3>

The asset that creates new functionality for terms and conditions. Terms are imported from csv files. When logging in, the user is checked for consent. If they are missing, a form with missing consents appears.
TODO
In Back Office it is not possible to create new term and condition, assign a cms page to it and save it in the database. This is a completely separate functionality that needs to be added in a future.
