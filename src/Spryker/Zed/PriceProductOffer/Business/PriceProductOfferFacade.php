<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductOffer\Business;

use ArrayObject;
use Generated\Shared\Transfer\PriceProductOfferCollectionTransfer;
use Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductOfferTransfer;
use Generated\Shared\Transfer\ValidationResponseTransfer;
use Generated\Shared\Transfer\WishlistItemTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\PriceProductOffer\Persistence\PriceProductOfferRepositoryInterface getRepository()
 * @method \Spryker\Zed\PriceProductOffer\Business\PriceProductOfferBusinessFactory getFactory()
 * @method \Spryker\Zed\PriceProductOffer\Persistence\PriceProductOfferEntityManagerInterface getEntityManager()
 */
class PriceProductOfferFacade extends AbstractFacade implements PriceProductOfferFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductOfferTransfer $productOfferTransfer
     *
     * @return \Generated\Shared\Transfer\ProductOfferTransfer
     */
    public function saveProductOfferPrices(ProductOfferTransfer $productOfferTransfer): ProductOfferTransfer
    {
        return $this->getFactory()->createPriceProductOfferWriter()->saveProductOfferPrices($productOfferTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    public function savePriceProductOfferRelation(PriceProductTransfer $priceProductTransfer): PriceProductTransfer
    {
        return $this->getFactory()->createPriceProductOfferWriter()->savePriceProductOfferRelation($priceProductTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductOfferTransfer $productOfferTransfer
     *
     * @return \Generated\Shared\Transfer\ProductOfferTransfer
     */
    public function expandProductOfferWithPrices(ProductOfferTransfer $productOfferTransfer): ProductOfferTransfer
    {
        return $this->getFactory()->createProductOfferExpander()->expandProductOfferWithPrices($productOfferTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductOfferCollectionTransfer $priceProductOfferCollectionTransfers
     *
     * @return \Generated\Shared\Transfer\ValidationResponseTransfer
     */
    public function validateProductOfferPrices(PriceProductOfferCollectionTransfer $priceProductOfferCollectionTransfers): ValidationResponseTransfer
    {
        return $this->getFactory()
            ->createPriceProductOfferValidator()
            ->validateProductOfferPrices($priceProductOfferCollectionTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductOfferCollectionTransfer $priceProductOfferCollectionTransfer
     *
     * @return void
     */
    public function deleteProductOfferPrices(PriceProductOfferCollectionTransfer $priceProductOfferCollectionTransfer): void
    {
        $this->getFactory()->createPriceProductOfferDeleter()->deleteProductOfferPrices($priceProductOfferCollectionTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer
     *
     * @return int
     */
    public function count(PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer): int
    {
        return $this->getRepository()->count($priceProductOfferCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function getProductOfferPrices(
        PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer
    ): ArrayObject {
        return $this->getFactory()
            ->createPriceProductOfferReader()
            ->getProductOfferPrices($priceProductOfferCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\WishlistItemTransfer $wishlistItemTransfer
     *
     * @return \Generated\Shared\Transfer\WishlistItemTransfer
     */
    public function expandWishlistItemWithPrices(WishlistItemTransfer $wishlistItemTransfer): WishlistItemTransfer
    {
        return $this->getFactory()->createPriceProductOfferWishlistExpander()->expandWishlistItemWithPrices($wishlistItemTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductOfferCollectionTransfer
     */
    public function getPriceProductOfferCollection(PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer): PriceProductOfferCollectionTransfer
    {
        return $this->getRepository()->getPriceProductOfferCollection($priceProductOfferCriteriaTransfer);
    }
}
