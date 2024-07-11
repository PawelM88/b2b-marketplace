<?php

declare(strict_types=1);

namespace Pyz\Zed\Term\Persistence\Mapper;

use DateTime;
use Exception;
use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermTransfer;

class TermMapper implements TermMapperInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\TermCollectionTransfer> $termCollection
     *
     * @return \Generated\Shared\Transfer\TermCollectionTransfer
     */
    public function mapTermCollectionToTermCollectionTransfer(array $termCollection): TermCollectionTransfer
    {
        $termCollectionTransfer = new TermCollectionTransfer();

        foreach ($termCollection as $term) {
            $termTransfer = new TermTransfer();

            $termTransfer->fromArray($term->toArray(), true);

            $updatedAtString = $termTransfer->getUpdatedAt();

            if ($updatedAtString) {
                try {
                    $updatedAt = new DateTime($updatedAtString);
                    $formattedUpdatedAt = $updatedAt->format('Y-m-d H:i:s');
                } catch (Exception $e) {
                    error_log('Error converting updatedAt to DateTime: ' . $e->getMessage());

                    $formattedUpdatedAt = null;
                }

                $termTransfer->setUpdatedAt($formattedUpdatedAt);
            }

            $termCollectionTransfer->addTerm($termTransfer);
        }

        return $termCollectionTransfer;
    }
}
