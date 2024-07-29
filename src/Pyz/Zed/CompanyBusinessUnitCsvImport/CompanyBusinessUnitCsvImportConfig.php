<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class CompanyBusinessUnitCsvImportConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const PREDEFINED_SALUTATION_MR = 'Mr';

    /**
     * @var string
     */
    public const PREDEFINED_SALUTATION_MRS = 'Mrs';

    /**
     * @var string
     */
    public const PREDEFINED_SALUTATION_MS = 'Ms';

    /**
     * @var string
     */
    public const PREDEFINED_SALUTATION_DR = 'Dr';

    /**
     * @var string
     */
    public const PREDEFINED_GENDER_MALE = 'Male';

    /**
     * @var string
     */
    public const PREDEFINED_GENDER_FEMALE = 'Female';

    /**
     * @var string
     */
    public const BRAND_ID = 'brand_id';

    /**
     * @var string
     */
    public const BRAND_NAME = 'brand_name';

    /**
     * @var string
     */
    public const BRAND_MARKET = 'brand_market';

    /**
     * @var string
     */
    public const BRAND_ACTIVE = 'brand_active';

    /**
     * @var string
     */
    public const BRAND_STATUS = 'brand_status';

    /**
     * @var string
     */
    public const SOLD_TO_ID = 'sold_to_id';

    /**
     * @var string
     */
    public const SOLD_TO_NAME = 'sold_to_name';

    /**
     * @var string
     */
    public const SHIP_TO_ID = 'ship_to_id';

    /**
     * @var string
     */
    public const SHIP_TO_NAME = 'ship_to_name';

    /**
     * @var string
     */
    public const EMAIL = 'email';

    /**
     * @var string
     */
    public const ADDRESS_ID = 'address_id';

    /**
     * @var string
     */
    public const ADDRESS1 = 'address1';

    /**
     * @var string
     */
    public const ADDRESS2 = 'address2';

    /**
     * @var string
     */
    public const ADDRESS3 = 'address3';

    /**
     * @var string
     */
    public const COUNTRY_ISO2_CODE = 'country_iso2_code';

    /**
     * @var string
     */
    public const STATE = 'state';

    /**
     * @var string
     */
    public const CITY = 'city';

    /**
     * @var string
     */
    public const ZIP_CODE = 'zip_code';

    /**
     * @var string
     */
    public const PHONE = 'phone';

    /**
     * @var string
     */
    public const ADMIN_SALUTATION = 'admin_salutation';

    /**
     * @var string
     */
    public const ADMIN_FIRST_NAME = 'admin_first_name';

    /**
     * @var string
     */
    public const ADMIN_LAST_NAME = 'admin_last_name';

    /**
     * @var string
     */
    public const ADMIN_EMAIL = 'admin_email';

    /**
     * @var string
     */
    public const ADMIN_PHONE = 'admin_phone';

    /**
     * @var string
     */
    public const STATUS_APPROVED = 'approved';

    /**
     * @var string
     */
    public const STATUS_PENDING = 'pending';

    /**
     * @var string
     */
    public const STATUS_DENIED = 'denied';

    /**
     * @return array<int, mixed>
     */
    public function getFieldsList(): array
    {
        return [
            static::BRAND_ID,
            static::BRAND_NAME,
            static::BRAND_MARKET,
            static::BRAND_ACTIVE,
            static::BRAND_STATUS,
            static::SOLD_TO_ID,
            static::SOLD_TO_NAME,
            static::SHIP_TO_ID,
            static::SHIP_TO_NAME,
            static::EMAIL,
            static::ADDRESS_ID,
            static::ADDRESS1,
            static::ADDRESS2,
            static::ADDRESS3,
            static::COUNTRY_ISO2_CODE,
            static::STATE,
            static::CITY,
            static::ZIP_CODE,
            static::PHONE,
            static::ADMIN_SALUTATION,
            static::ADMIN_FIRST_NAME,
            static::ADMIN_LAST_NAME,
            static::ADMIN_EMAIL,
            static::ADMIN_PHONE,
        ];
    }
}
