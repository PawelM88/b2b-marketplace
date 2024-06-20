# Creation of a new store
**Application**
- Add `SPRYKER_YVES_HOST_<store>`, region, store, group, docker.testing.store in `docker.dev.yml`
    - [optional] **TBC** Set `SPRYKER_ACTIVE_STORES`
- Add and configure store in `config/Shared/stores.php`
- Add cloud install config in `config/install/<region>`
- Update `yml` files in `config/install`, e.g. `docker.ci.*`, `testing.yml` <span style="color:red">*</span>
- Add export config in `data/export`
- Import data ***
    - Add import data in `data/import/common/<store>/`
    - Add import data/locales in `data/import/common/common/`
    - Add import data/locales directly in files `data/import/common/*`
    - Set fallback data import config file path in `src/Pyz/Zed/DataImport/DataImportConfig.php` <span style="color:red">**</span>
- Add data import config in `data/import/local` and `data/import/production`
- Replace fallback store key in `config/Shared/default_store.php` <span style="color:red">**</span>
- Update `FILESYSTEM_SERVICE` array in `config/Shared/config_default.php` <span style="color:red">**</span>
- [optional] Update `TRANSLATION_ZED_FALLBACK_LOCALES` in `config/Shared/config_default.php`
- [optional] Add code buckets in `src/SprykerConfig/CodeBucketConfig.php` (region name)
    - Set new entry as first entry <span style="color:red">**</span>
- Update `getLocalizedTermsAndConditionsPageLinks` in `src/Pyz/Yves/CheckoutPage/CheckoutPageConfig.php`
- Update stock mapping in `src/Pyz/Zed/Stock/StockConfig.php`
- [optional] **TBC** Update `getDefaultLocaleCode()` in `src/Pyz/Client/RabbitMq/RabbitMqConfig.php`

**Tests**
- Update store configuration (code, currency, locale) for <u>all</u> tests <span style="color:red">**</span> in `tests` folder
    - Create a store in `tests/PyzTest/Zed/Console/_data/cli_sandbox/config/Shared/stores.php`
    - Update a `tests/PyzTest/Zed/Console/_data/cli_sandbox/config/Shared/default_store.php`
    - Update a `tests/PyzTest/Shared/Testify/_support/Helper/Environment.php`
- Update `data/import/common/minimal.yml`
- Create store specific config e.g. `tests/PyzTest/Zed/Console/_data/cli_sandbox/config/Shared/config_default-development_AU.php`
- Update Yves and Zed hosts, `STORE_TO_YVES_HOST_MAPPING` and `REGION_TO_YVES_HOST_MAPPING` in `tests/PyzTest/Zed/Console/_data/cli_sandbox/config/Shared/config_default.php` <span style="color:red">**</span>
- Update test hostnames and DB name in `tests/PyzTest/Zed/Console/_data/cli_sandbox/config/Shared/config_default-ci.php` <span style="color:red">**</span>
- Update active stores in `config/Shared/stores.php` <span style="color:red">*</span>, <span style="color:red">**</span><br/>For testing instance active stores are hardcoded to `DE` and `AT`. In case a new store is added it will not be found and tests will fail. Example:
  ```php
  if (getenv('SPRYKER_ACTIVE_STORES')) {
    ...
    //condition implemented for testing the entire Spryker with the codecept run command
    if (in_array('DE', $activeStores) && in_array('AT', $activeStores)) {
        $activeStores[0] = 'AU';
        array_pop($activeStores);
    }
    ...
  }
  ```
- Update `APPLICATION_STORE` in `tests/PyzTest/Zed/Console/_data/console_runner.php` <span style="color:red">**</span>
- Update configuration in `deploy.ci.*` files

**CI**
- Update in `APPLICATION_STORE` environment variable in `.github/workflows/ci.yml`

<br/>
<span style="color:red">*</span> apply in case testing are to be executed against new store<br/>
<span style="color:red">**</span> apply in case new store must be the default store<br/>
<span style="color:red">***</span> in case of demo data are created on a basis of official Sprykle demo data (EU), ensure all files consists of expected data, e.g. `price_product_offer.csv`<br/>

## Cloud readiness:
https://docs.spryker.com/docs/cloud/dev/spryker-cloud-commerce-os/multi-store-setups/checklist-for-a-new-store-implementation.html#setup-1

## Clean up
- Remove unused stuff from places mentioned in `New store`
- Remove demo admins from `src/Pyz/Zed/User/UserConfig.php` and related data

## Testing
Check RabbitMQ queues/error queues, see Scheduler (Jenkins) jobs
Perform functional smoke tests: create a user, login, place an order as guest/logged in user

## Security
- Replace defaults in `config/Shared/common/config_oauth.php` to harden CI pipelines
    - Replace hardcoded values to environment variables or vault
- Replace default admin credentials in `src/Pyz/Zed/User/UserConfig.php`
    - Remove default admin

## TO DO
Update warehouses: `src/Pyz/Zed/Stock/StockConfig.php`
