<?php

declare(strict_types=1);

namespace Pyz\Glue\ContentItemsRestApi;

use Pyz\Client\ContentItemStorage\ContentItemStorageClientInterface;
use Pyz\Glue\ContentItemsRestApi\Processor\Reader\ContentItemReader;
use Pyz\Glue\ContentItemsRestApi\Processor\Reader\ContentItemReaderInterface;
use Pyz\Glue\ContentItemsRestApi\Processor\RestResponseBuilder\ContentItemsRestResponseBuilder;
use Pyz\Glue\ContentItemsRestApi\Processor\RestResponseBuilder\ContentItemsRestResponseBuilderInterface;
use Spryker\Glue\Kernel\Backend\AbstractFactory;

class ContentItemsRestApiFactory extends AbstractFactory
{
    /**
     * @throws \Spryker\Glue\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Glue\ContentItemsRestApi\Processor\Reader\ContentItemReaderInterface
     */
    public function createContentItemReader(): ContentItemReaderInterface
    {
        return new ContentItemReader(
            $this->getContentItemStorageClient(),
            $this->createContentItemRestResponseBuilder(),
        );
    }

    /**
     * @throws \Spryker\Glue\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Client\ContentItemStorage\ContentItemStorageClientInterface
     */
    public function getContentItemStorageClient(): ContentItemStorageClientInterface
    {
        return $this->getProvidedDependency(ContentItemsRestApiDependencyProvider::CLIENT_CONTENT_ITEM_STORAGE);
    }

    /**
     * @return \Pyz\Glue\ContentItemsRestApi\Processor\RestResponseBuilder\ContentItemsRestResponseBuilderInterface
     */
    public function createContentItemRestResponseBuilder(): ContentItemsRestResponseBuilderInterface
    {
        return new ContentItemsRestResponseBuilder(
            $this->getResourceBuilder(),
        );
    }
}
