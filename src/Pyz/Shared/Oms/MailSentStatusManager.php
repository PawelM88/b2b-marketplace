<?php

declare(strict_types=1);

namespace Pyz\Shared\Oms;

class MailSentStatusManager
{
    /**
     * @var \Pyz\Shared\Oms\MailSentStatusManager|null
     */
    private static ?MailSentStatusManager $instance = null;

    /**
     * @var bool
     */
    public static bool $mailSent = false;

    private function __construct()
    {
    }

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
