<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PyzTest\Zed\MerchantPaymentCommission\Business;

use Codeception\Test\Unit;
use PyzTest\Zed\MerchantPaymentCommission\MerchantPaymentCommissionBusinessTester;

/**
 * @group PyzTest
 * @group Zed
 * @group MerchantPaymentCommission
 * @group Business
 * @group MerchantPaymentCommissionFacadeTest
 */
class MerchantPaymentCommissionFacadeTest extends Unit
{
    /**
     * @var \PyzTest\Zed\MerchantPaymentCommission\MerchantPaymentCommissionBusinessTester
     */
    protected MerchantPaymentCommissionBusinessTester $tester;

    /**
     * @return void
     */
    public function testCreateMerchantPaymentCommissionPersistsToDatabase(): void
    {
        // Arrange
        $merchantTransfer = $this->tester->getMerchantTransfer()->setIdMerchant(1);
        $merchantPaymentCommissionTransfer = $this->tester->getMerchantPaymentCommissionTransfer($merchantTransfer);

        // Act
        $merchantPaymentCommissionTransfer = $this->tester->getFacade()->createMerchantPaymentCommission(
            $merchantPaymentCommissionTransfer
        );

        // Assert
        $this->assertNotNull($merchantPaymentCommissionTransfer->getIdMerchantPaymentCommission());
    }

    /**
     * @return void
     */
    public function testUpdateMerchantPaymentCommission(): void
    {
        // Arrange
        $merchantTransfer = $this->tester->getMerchantTransfer()->setIdMerchant(1);
        $merchantPaymentCommissionTransfer = $this->tester->getMerchantPaymentCommissionTransfer($merchantTransfer);
        $merchantPaymentCommissionTransfer = $this->tester->getFkStore($merchantPaymentCommissionTransfer);
        $merchantTransfer->setMerchantPaymentCommission($merchantPaymentCommissionTransfer);

        // Act
        $merchantResponseTransfer = $this->tester->getFacade()->postUpdateMerchantPaymentCommission($merchantTransfer);

        // Assert
        $merchantPaymentCommissionsPerStore = $merchantResponseTransfer->getMerchant()->getMerchantPaymentCommission(
        )->getMerchantPaymentCommissionPerStore();

        foreach ($merchantPaymentCommissionsPerStore as $merchantPaymentCommissionPerStore) {
            $merchantPaymentCommissionValue = $merchantPaymentCommissionPerStore->getMerchantPaymentCommissionValues();

            $this->assertNotNull($merchantPaymentCommissionValue->getIdMerchantPaymentCommission());
        }

        $this->assertTrue($merchantResponseTransfer->getIsSuccess());
    }

    /**
     * @return void
     * @throws \Spryker\Zed\Store\Business\Model\Exception\StoreNotFoundException
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function testFindMerchantPaymentCommissionsPerStore(): void
    {
        // Arrange
        $merchantTransfer = $this->tester->getMerchantTransfer()->setIdMerchant(1);
        $merchantPaymentCommissionValuesTransfer = $this->tester->getMerchantPaymentCommissionValuesTransfer(
            $merchantTransfer
        );
        $storesNumber = $this->tester->getStoresNumber();

        // Act
        $merchantPaymentCommissionsPerStore = $this->tester->getFacade()->findMerchantPaymentCommissionsPerStore(
            $merchantPaymentCommissionValuesTransfer
        );

        // Assert
        foreach ($merchantPaymentCommissionsPerStore as $merchantPaymentCommissionPerStore) {
            $merchantPaymentCommissionValuesTransfer = $merchantPaymentCommissionPerStore->getMerchantPaymentCommissionValues(
            );

            $this->assertNotEmpty($merchantPaymentCommissionValuesTransfer->getIdMerchantPaymentCommission());
        }

        $this->assertCount($storesNumber, $merchantPaymentCommissionsPerStore);
    }
}
