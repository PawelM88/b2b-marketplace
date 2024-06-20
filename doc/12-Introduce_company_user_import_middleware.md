# Introduce company user import middleware

Modules in Zed: Process and CompanyUserMiddlewareConnector

The task of these modules is to import data from company_user.xml file into spy_company_user table.<br>
The data is validated, mapped, formatted, and translated for the needs of the Spryker.

## company_user.xml file

The following xml file contains the data needed to import. It imitates data recording used in another, external system.
There are visible differences in field names and values between it and Spryker's company_user.csv file, e.g.:

 xml file               | csv file           
------------------------|--------------------
 company_user_signature | company_user_key   
 customer_number        | customer_reference 
 company_signature      | company_key        
 Spryker-user:12        | Spryker--12        
 PL:2                   | DE--2              
 Spryker                | spryker_systems    

```xml lines
<?xml version="1.0"?>
<company_users_list>
    <company_user>
        <company_user_signature>Spryker-user:12</company_user_signature>
        <customer_number>PL:2</customer_number>
        <company_signature>Spryker</company_signature>
    </company_user>
    <company_user>
        <company_user_signature>Spryker-user:13</company_user_signature>
        <customer_number>PL:3</customer_number>
        <company_signature>Spryker</company_signature>
    </company_user>
    <company_user>
        <company_user_signature>Spryker-user:14</company_user_signature>
        <customer_number>PL:4</customer_number>
        <company_signature>Spryker</company_signature>
    </company_user>
    <company_user>
        <company_user_signature>Spryker-user:15</company_user_signature>
        <customer_number></customer_number>
        <company_signature>Spryker</company_signature>
    </company_user>
    <company_user>
        <company_user_signature>Spryker-user:16#</company_user_signature>
        <customer_number>PL:28</customer_number>
        <company_signature>Spryker</company_signature>
    </company_user>
    <company_user>
        <company_user_signature>Spryker-user:17$</company_user_signature>
        <customer_number>PL:29</customer_number>
        <company_signature>Spryker</company_signature>
    </company_user>
    <company_user>
        <company_user_signature>Spryker-user:18</company_user_signature>
        <customer_number>PL:30</customer_number>
        <company_signature>Spryker_as_the_best_e-commerce</company_signature>
    </company_user>
</company_users_list>
```

In addition to name differences, some data in the xml file does not contain all fields or is empty, e.g.:
empty `customer_number`, lack of `is_default` field. On the other hand the `company_user_signature` field contains `#`
and `$` sign which is incorrect.

## Middleware process

The middleware process will proceed as follows:

1. First file company_user.xml will be read
2. Each line of the file will be validated (what does not pass - will be rejected)
3. All fields in the file will be mapped to those required by Spryker
4. The field values will be translated and formatted to the format required by Spryker
5. Data that has passed the process of validation, mapping and translation will be added to the spy_company_user table
   in
   the database

### company_user.xml file localization

data/import/middleware/company_user.xml

### Data validation

1. Field `company_user_signature` can not have `#` and `$` sign (Plugin NotContain)
2. Field `customer_number` can not be empty (Plugin NotBlank)
3. Field `company_signature` can contain up to 15 characters (Plugin Length)

Rows that fail the validation will be rejected when saving to the table.

### Field mapping

For mapping is responsible CompanyUserMap

 Field names in xml file  | Target field names   
--------------------------|----------------------
 `company_user_signature` | `company_user_key`   
 `customer_number`        | `customer_reference` 
 `company_signature`      | `company_key`        

### Modification of field values

For translating is responsible

1. In field `company_user_signature` - the word `user:` is replaced by the dash `-` and the number is passed
   on (
   Plugin UserRemove)
2. In field `customer_number` - the shortcut name of the country is replaced by the prefix `DE` and the number is passed
   on (Plugin
   CountryNamePlToDe)
3. In field `company_signature` - the original company name is lowercase and word `_systems` is added (Plugin
   CompanyKeyReformat)

## How to build your own middleware module from scratch?

Building your own middleware module has already been described in a great way in the task:<br>
#172 Import abstract products via middleware<br>
https://github.com/ATC-Adobe/spryker-asset-harvest/blob/172-import-abstract-products-via-middleware/docs/172-import-abstract-products-via-middleware.md

## Steps

Since the namespace and console command have already been added, you need to download spryker-middleware/process by
composer, and then generate some transfers.

1. First go to docker/sdk tool

```shell
docker/sdk cli
```

2. Download spryker-middleware/process

```shell
composer require "spryker-middleware/process":"^1.3"
```

3. Generate transfers

```shell
console transfer:generate
```

## Starting the middleware process

The xml file, apart from its structure, also differs from the json file with the command to be entered:

```shell
console middleware:process:run -p COMPANY_USER_PROCESS -i data/import/middleware/company_user.xml -t '{"rootNodeName": "company_user"}'
```

For `xml` files, you must enter an additional option (`-t`) in the `json` format. The `rootNodeName` must be included
for the output file. If you look at the `company_user.xml` file, you will see that it will be `company_user` tag. <br>

If instead of writing to the table in the database, you would like to write to the second `xml` file, then you need to
add the second option (`-u`) with two data `rootNodeName` and `entityNodeName`. In this case it will
be `company_users_list` for `rootNodeName` and `company_user` for `entityNodeName`:

```shell
console middleware:process:run -p COMPANY_USER_PROCESS -i data/import/middleware/company_user.xml -o data/import/middleware/company_user_out.xml -t '{"rootNodeName": "company_user"}' -u '{"rootNodeName": "company_users_list", "entityNodeName":
"company_user"}'
```

In Cli console You will see a very big message. That is fine - it only means that validator detected a mismatch and the
row was skipped (you can format this message in some json file or Postman and read it)

Now you can check the spy_company_user table and see there three additional entries

## Troubleshooting

1. It may happen that in CompanyUserMiddlewareConnectorDependencyProvider the getLocator() function will not see the
   process service. Then type in the Cli console:

```shell
console dev:ide-auto-completion:generate
```
