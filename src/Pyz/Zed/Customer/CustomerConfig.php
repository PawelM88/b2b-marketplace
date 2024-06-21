<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Customer;

use Spryker\Zed\Customer\CustomerConfig as SprykerCustomerConfig;

class CustomerConfig extends SprykerCustomerConfig
{
    /**
     * @var bool
     */
    protected const PASSWORD_RESET_EXPIRATION_IS_ENABLED = true;

    /**
     * @var int
     */
    protected const MIN_LENGTH_CUSTOMER_PASSWORD = 8;

    /**
     * @var int
     */
    protected const MAX_LENGTH_CUSTOMER_PASSWORD = 64;

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
     * {@inheritDoc}
     *
     * @return array<string>
     */
    public function getCustomerPasswordAllowList(): array
    {
        return [
            'change123',
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @return array<string>
     */
    public function getCustomerPasswordDenyList(): array
    {
        return [
            'qwerty',
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function isRestorePasswordValidationEnabled(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getCustomerPasswordCharacterSet(): string
    {
        return "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@#$%^&(){}:;\[\]<>,.?\/~_+\-=|])[a-zA-Z0-9*.!@#$%^& (){}:;\[\]<>,.?\/~_+\-=|]*$/";
    }

    /**
     * {@inheritDoc}
     *
     * @return int|null
     */
    public function getCustomerPasswordSequenceLimit(): ?int
    {
        return 3;
    }

    /**
     * {@inheritDoc}
     *
     * @return array<string>
     */
    public function getCustomerDetailExternalBlocksUrls(): array
    {
        return [
                'sales' => '/sales/customer/customer-orders',
                'notes' => '/customer-note-gui/index/index',
            ] + parent::getCustomerDetailExternalBlocksUrls();
    }

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function isDoubleOptInEnabled(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @return string|null
     */
    public function getCustomerSequenceNumberPrefix(): ?string
    {
        return 'customer';
    }

    /**
     * @return array<string>
     */
    public function getFileMimeTypes(): array
    {
        return ['text/csv'];
    }

    /**
     * @return string
     */
    public function getMaxFileSize(): string
    {
        return '50M';
    }
}
