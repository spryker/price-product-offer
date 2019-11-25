<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Product\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductUrlFilterTransfer;
use Spryker\Zed\Product\Business\Product\Sku\SkuGenerator;
use Spryker\Zed\Product\Business\ProductFacade;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Product
 * @group Business
 * @group Facade
 * @group ProductFacadeTest
 * Add your own group annotations below this line
 */
class ProductFacadeTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\Product\ProductBusinessTester
     */
    protected $tester;

    /**
     * @var \Spryker\Zed\Product\Business\ProductFacadeInterface
     */
    protected $productFacade;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->tester->setUpDatabase();
        $this->productFacade = new ProductFacade();
    }

    /**
     * @return void
     */
    public function testGenerateProductConcreteSku(): void
    {
        $sku = $this->productFacade->generateProductConcreteSku(
            $this->createProductAbstractTransfer(),
            $this->createProductConcreteTransfer()
        );

        $this->assertSame($this->getExpectedProductConcreteSku(), $sku);
    }

    /**
     * @return void
     */
    public function testGetProductConcreteTransfersByProductIdsRetrievesAllSpecifiedProductconcreteAsTransferWithId(): void
    {
        $productConcreteIds = $this->tester->getProductConcreteIds();

        $this->assertTrue(count($productConcreteIds) > 0);
        $productConcreteTransfers = $this->tester->getProductFacade()->getProductConcreteTransfersByProductIds($productConcreteIds);
        $this->assertSame(count($productConcreteIds), count($productConcreteTransfers));

        foreach ($productConcreteTransfers as $productConcreteTransfer) {
            $this->assertInstanceOf(ProductConcreteTransfer::class, $productConcreteTransfer);
            $this->assertContains($productConcreteTransfer->getIdProductConcrete(), $productConcreteIds);
        }
    }

    /**
     * @return void
     */
    public function testGetProductConcreteTransfersByProductAbstractIds(): void
    {
        $productAbstractIds = $this->tester->getProductAbstractIds();

        $this->assertTrue(count($productAbstractIds) > 0);
        $productConcreteTransfers = $this->tester->getProductFacade()->getProductConcreteTransfersByProductAbstractIds($productAbstractIds);

        foreach ($productConcreteTransfers as $productConcreteTransfer) {
            $this->assertInstanceOf(ProductConcreteTransfer::class, $productConcreteTransfer);
            $this->assertContains($productConcreteTransfer->getFkProductAbstract(), $productAbstractIds);
        }
    }

    /**
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected function createProductAbstractTransfer(): ProductAbstractTransfer
    {
        $productAbstractTransfer = new ProductAbstractTransfer();
        $productAbstractTransfer->setSku('abstract_sku');

        return $productAbstractTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected function createProductConcreteTransfer(): ProductConcreteTransfer
    {
        $productConcreteTransfer = new ProductConcreteTransfer();
        $productConcreteTransfer->setAttributes([
            'processor_frequency' => '4 GHz',
            'processor_cache' => '12 MB',
        ]);

        return $productConcreteTransfer;
    }

    /**
     * @return string
     */
    protected function getExpectedProductConcreteSku(): string
    {
        return 'abstract_sku' .
            SkuGenerator::SKU_ABSTRACT_SEPARATOR .
            'processor_frequency' .
            SkuGenerator::SKU_TYPE_SEPARATOR .
            '4GHz' .
            SkuGenerator::SKU_VALUE_SEPARATOR .
            'processor_cache' .
            SkuGenerator::SKU_TYPE_SEPARATOR .
            '12MB';
    }

    /**
     * @return void
     */
    public function testGetProductsUrlsForOneProduct(): void
    {
        //Arrange
        $productAbstractId = $this->tester->getProductAbstractIds()[0];

        $productUrlFilterTransfer = new ProductUrlFilterTransfer();
        $productUrlFilterTransfer->setProductAbstractIds([$productAbstractId]);
        $productUrlFilterTransfer->setIdLocale($this->tester->getLocaleFacade()->getCurrentLocale()->getIdLocale());

        $correctUrl = $this->tester->getProductUrl($productAbstractId, $this->tester->getLocaleFacade()->getCurrentLocale()->getLocaleName());

        // Act
        $productsUrls = $this->tester->getProductFacade()->getProductsUrls($productUrlFilterTransfer);

        // Assert
        $this->assertCount(1, $productsUrls);

        foreach ($productsUrls as $productUrl) {
            $this->assertEquals($correctUrl, $productUrl->getUrl());
        }
    }

    /**
     * @return void
     */
    public function testGetProductsUrlsWithoutProductIds(): void
    {
        //Arrange
        $productUrlFilterTransfer = new ProductUrlFilterTransfer();
        $productUrlFilterTransfer->setIdLocale($this->tester->getLocaleFacade()->getCurrentLocale()->getIdLocale());

        // Act
        $productUrls = $this->tester->getProductFacade()->getProductsUrls($productUrlFilterTransfer);

        // Assert
        $this->assertCount(0, $productUrls);
    }

    /**
     * @return void
     */
    public function testGetProductsUrlsWithoutLocale(): void
    {
        //Arrange
        $productAbstractId = $this->tester->getProductAbstractIds()[0];

        $productUrlFilterTransfer = new ProductUrlFilterTransfer();
        $productUrlFilterTransfer->setProductAbstractIds([$productAbstractId]);

        // Act
        $productsUrls = $this->tester->getProductFacade()->getProductsUrls($productUrlFilterTransfer);

        // Assert
        $this->assertCount(2, $productsUrls);

        foreach ($productsUrls as $productUrl) {
            $this->assertEquals($productAbstractId, $productUrl->getFkResourceProductAbstract());
        }
    }
}
