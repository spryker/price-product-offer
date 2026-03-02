<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductOffer\Persistence;

use Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Orm\Zed\PriceProductOffer\Persistence\SpyPriceProductOffer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Spryker\Zed\PriceProductOffer\Persistence\PriceProductOfferPersistenceFactory getFactory()
 */
class PriceProductOfferEntityManager extends AbstractEntityManager implements PriceProductOfferEntityManagerInterface
{
    public function createPriceProductOfferRelation(PriceProductTransfer $priceProductTransfer): PriceProductTransfer
    {
        $priceProductOfferMapper = $this->getFactory()->createPriceProductOfferMapper();

        $priceProductOfferEntity = $priceProductOfferMapper->mapPriceProductTransferToPriceProductOfferEntity(
            $priceProductTransfer,
            new SpyPriceProductOffer(),
        );

        $priceProductOfferEntity->save();

        return $priceProductOfferMapper->mapPriceProductOfferEntityToPriceProductTransfer(
            $priceProductOfferEntity,
            $priceProductTransfer,
        );
    }

    public function updatePriceProductOfferRelation(PriceProductTransfer $priceProductTransfer): PriceProductTransfer
    {
        /** @var \Generated\Shared\Transfer\PriceProductDimensionTransfer $priceDimensionTransfer */
        $priceDimensionTransfer = $priceProductTransfer->requirePriceDimension()->getPriceDimension();
        /** @var int $idPriceProductOffer */
        $idPriceProductOffer = $priceDimensionTransfer->requireIdPriceProductOffer()->getIdPriceProductOffer();

        $priceProductOfferEntity = $this->getFactory()
            ->getPriceProductOfferPropelQuery()
            ->filterByIdPriceProductOffer($idPriceProductOffer)
            ->findOne();

        if (!$priceProductOfferEntity) {
            return $priceProductTransfer;
        }

        $priceProductOfferMapper = $this->getFactory()->createPriceProductOfferMapper();

        $priceProductOfferEntity = $priceProductOfferMapper->mapPriceProductTransferToPriceProductOfferEntity(
            $priceProductTransfer,
            $priceProductOfferEntity,
        );
        $priceProductOfferEntity->save();

        return $priceProductOfferMapper->mapPriceProductOfferEntityToPriceProductTransfer(
            $priceProductOfferEntity,
            $priceProductTransfer,
        );
    }

    public function delete(PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer): void
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $priceProductOfferCollection */
        $priceProductOfferCollection = $this->getFactory()
            ->getPriceProductOfferPropelQuery()
            ->filterByIdPriceProductOffer_In($priceProductOfferCriteriaTransfer->getPriceProductOfferIds())
            ->find();
        $priceProductOfferCollection->delete();
    }
}
