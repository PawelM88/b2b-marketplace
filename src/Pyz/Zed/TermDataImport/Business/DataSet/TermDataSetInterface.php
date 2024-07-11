<?php

namespace Pyz\Zed\TermDataImport\Business\DataSet;

interface TermDataSetInterface
{
    /**
     * @var string
     */
    public const COLUMN_TERM_KEY = 'term_key';

    /**
     * @var string
     */
    public const COLUMN_NAME = 'name';

    /**
     * @var string
     */
    public const COLUMN_FK_CMS_PAGE = 'fk_cms_page';
}
