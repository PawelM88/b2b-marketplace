# Automatic creation of company roles by data import

By default, Spryker allows you to freely create companies, roles, and assign permissions to them using csv files.
However, with a large number of companies, writing out so much data for each of them in csv files is very
time-consuming. The asset retrieves data about the company from the `company.csv` file and creates roles with
permissions for each existing company based on what is included in the CompanyRoleConfig class.<br>
The whole thing is divided into 3 stages:

1. Data about the company is placed in the data/import/common/common/company.csv file
2. Newly created module `CompanyDataImport` in addition to saving data about the company to the database, refers to the
   vendor facade to create predefined roles for the company.
3. The `CompanyRoleConfig` class determines what roles need to be created and what permissions to grant them.

## Modifying the number of company roles and permissions

As mentioned above, company roles and permissions can be modified in the src/Pyz/Zed/CompanyRole/CompanyRoleConfig
class.

To add new role e.g. `Marketer` it has to be done:

1) Add new constant

```php 
/**
* @var string
*/
protected const MARKETER_ROLE_NAME = 'Marketer';
```

2) To method `getPredefinedCompanyRoles()` add new `getMarketerRole()` method.

```php
/**
* @return array<\Generated\Shared\Transfer\CompanyRoleTransfer>
*/
public function getPredefinedCompanyRoles(): array
{
    $companyRoleTransfers = parent::getPredefinedCompanyRoles();
    $companyRoleTransfers[] = $this->getBuyerRole();
    $companyRoleTransfers[] = $this->getMarketerRole();

    return $companyRoleTransfers;
}
````

3) Create this new method getMarketerRole()

```php
/**
* @return \Generated\Shared\Transfer\CompanyRoleTransfer
*/
protected function getMarketerRole(): CompanyRoleTransfer
{
    return (new CompanyRoleTransfer())
        ->setName(static::MARKETER_ROLE_NAME)
        ->setPermissionCollection($this->createPermissionCollectionFromPermissionKeys(
            $this->getMarketerRolePermissionKeys(),
        ));
}
````

4) Assign the permissions you want. The permissions that can be assigned are implemented
   in `PermissionDependencyProvider`

```php
/**
* @return array<string>
*/
protected function getMarketerRolePermissionKeys(): array
{
    return [
        ManageCompanyUserInvitationPermissionPlugin::KEY,
        SeePricePermissionPlugin::KEY,
        SeeShoppingListPermissionPlugin::KEY,
    ];
}
```

The `Administrator` role is placed in the vendor `Spryker\Zed\CompanyRole\CompanyRoleConfig`.<br>
To remove a role, delete all the above methods and the constant. Don't forget to remove the permission names (which are
Plugins) from `use` at the top of the CompanyRoleConfig class.

### CSV files

After modifying the number and names of roles along with their permissions, you still need to change the data (it is
best to clear it) in the files:

- `company_role.csv` - creates roles and assigns them to companies
- `company_role_permission.csv` - assigns permissions to company roles
- `company_user_role` - assigns company roles to users

If the above files contain data regarding roles and their permissions, they will be duplicated. The task of creating
roles is already completed when companies are imported from company.csv file.

### Console Commands

Go to the docker/sdk cli tool

```shell
docker/sdk cli
```

For import only companies with creation of company roles type:

```shell
console data:import:companies
```
