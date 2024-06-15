<?php

declare(strict_types=1);

namespace Pyz\Yves\MerchantPage;

use Spryker\Yves\Kernel\AbstractBundleConfig;

class MerchantPageConfig extends AbstractBundleConfig
{
    /**
     * Specification:
     * - Regular expression to validate User First Name field.
     *
     * @api
     *
     * @var string
     */
    public const PATTERN_FIRST_NAME = '/^[^\d!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]+$/';

    /**
     * Specification:
     * - Regular expression to validate User Last Name field.
     *
     * @api
     *
     * @var string
     */
    public const PATTERN_LAST_NAME = '/^[^\d!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]+$/';

    /**
     * Specification:
     * - Regular expression to validate User Phone Number field.
     *
     * @api
     *
     * @var string
     */
    public const PATTERN_PHONE_NUMBER = '/^[1-9]\d*$/';

    /**
     * Specification:
     * - Regular expression to validate Subject field.
     *
     * @api
     *
     * @var string
     */
    public const PATTERN_SUBJECT = '/^[a-zA-Z0-9\s.,!?()]+$/';
}
