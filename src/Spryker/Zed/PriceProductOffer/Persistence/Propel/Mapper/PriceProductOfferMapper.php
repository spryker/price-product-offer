<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductOffer\Persistence\Propel\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Generated\Shared\Transfer\PriceProductOfferCollectionTransfer;
use Generated\Shared\Transfer\PriceProductOfferTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\PriceTypeTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Currency\Persistence\SpyCurrency;
use Orm\Zed\PriceProduct\Persistence\SpyPriceProductStore;
use Orm\Zed\PriceProduct\Persistence\SpyPriceType;
use Orm\Zed\PriceProductOffer\Persistence\SpyPriceProductOffer;
use Orm\Zed\Store\Persistence\SpyStore;
use Propel\Runtime\Collection\Collection;

class PriceProductOfferMapper
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param \Orm\Zed\PriceProductOffer\Persistence\SpyPriceProductOffer $priceProductOfferEntity
     *
     * @return \Orm\Zed\PriceProductOffer\Persistence\SpyPriceProductOffer
     */
    public function mapPriceProductTransferToPriceProductOfferEntity(
        PriceProductTransfer $priceProductTransfer,
        SpyPriceProductOffer $priceProductOfferEntity
    ): SpyPriceProductOffer {
        /** @var \Generated\Shared\Transfer\PriceProductDimensionTransfer $priceDimensionTransfer */
        $priceDimensionTransfer = $priceProductTransfer->requirePriceDimension()->getPriceDimension();
        /** @var \Generated\Shared\Transfer\MoneyValueTransfer $moneyValueTransfer */
        $moneyValueTransfer = $priceProductTransfer->requireMoneyValue()->getMoneyValue();
        /** @var int $idProductOffer */
        $idProductOffer = $priceDimensionTransfer->getIdProductOffer();
        $priceProductOfferEntity->setFkProductOffer($idProductOffer);
        $priceProductOfferEntity->setFkPriceProductStore((string)$moneyValueTransfer->getIdEntity());

        return $priceProductOfferEntity;
    }

    /**
     * @param \Propel\Runtime\Collection\Collection $priceProductOfferEntities
     * @param \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function mapPriceProductOfferEntitiesToPriceProductTransfers(
        Collection $priceProductOfferEntities,
        ArrayObject $priceProductTransfers
    ): ArrayObject {
        foreach ($priceProductOfferEntities as $priceProductOfferEntity) {
            $priceProductTransfer = $this->mapPriceProductOfferEntityToPriceProductTransfer(
                $priceProductOfferEntity,
                new PriceProductTransfer(),
            );
            $priceProductTransfers->append($priceProductTransfer);
        }

        return $priceProductTransfers;
    }

    /**
     * @param \Orm\Zed\PriceProductOffer\Persistence\SpyPriceProductOffer $priceProductOfferEntity
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    public function mapPriceProductOfferEntityToPriceProductTransfer(
        SpyPriceProductOffer $priceProductOfferEntity,
        PriceProductTransfer $priceProductTransfer
    ): PriceProductTransfer {
        $priceProductTransfer = $this->mapPriceProductStoreEntityToPriceProductTransfer(
            $priceProductOfferEntity->getSpyPriceProductStore(),
            $priceProductTransfer,
        );
        $priceProductTransfer->setPriceDimension(
            (new PriceProductDimensionTransfer())
                ->setIdProductOffer($priceProductOfferEntity->getFkProductOffer())
                ->setIdPriceProductOffer((int)$priceProductOfferEntity->getIdPriceProductOffer()),
        );

        return $priceProductTransfer;
    }

    /**
     * @param \Propel\Runtime\Collection\Collection<\Orm\Zed\PriceProductOffer\Persistence\SpyPriceProductOffer> $priceProductOfferEntities
     * @param \Generated\Shared\Transfer\PriceProductOfferCollectionTransfer $priceProductOfferCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductOfferCollectionTransfer
     */
    public function mapPriceProductOfferEntitiesToPriceProductOfferCollectionTransfer(
        Collection $priceProductOfferEntities,
        PriceProductOfferCollectionTransfer $priceProductOfferCollectionTransfer
    ): PriceProductOfferCollectionTransfer {
        foreach ($priceProductOfferEntities as $priceProductOfferEntity) {
            $priceProductOfferCollectionTransfer->addPriceProductOffer(
                $this->mapPriceProductOfferEntityToPriceProductOfferTransfer(
                    $priceProductOfferEntity,
                    new PriceProductOfferTransfer(),
                ),
            );
        }

        return $priceProductOfferCollectionTransfer;
    }

    /**
     * @param \Orm\Zed\PriceProduct\Persistence\SpyPriceProductStore $priceProductStoreEntity
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    protected function mapPriceProductStoreEntityToPriceProductTransfer(
        SpyPriceProductStore $priceProductStoreEntity,
        PriceProductTransfer $priceProductTransfer
    ): PriceProductTransfer {
        $priceProductTransfer->setIdPriceProduct($priceProductStoreEntity->getFkPriceProduct())
            ->setIdProduct($priceProductStoreEntity->getPriceProduct()->getFkProduct());
        $priceProductTransfer = $priceProductTransfer->setMoneyValue(
            $this->mapPriceProductStoreEntityToMoneyValueTransfer(
                $priceProductStoreEntity,
                new MoneyValueTransfer(),
            ),
        );
        $priceProductTransfer->setPriceType(
            $this->mapPriceTypeEntityToPriceTypeTransfer(
                $priceProductStoreEntity->getPriceProduct()->getPriceType(),
                new PriceTypeTransfer(),
            ),
        );

        return $priceProductTransfer;
    }

    /**
     * @param \Orm\Zed\PriceProduct\Persistence\SpyPriceProductStore $priceProductStoreEntity
     * @param \Generated\Shared\Transfer\MoneyValueTransfer $moneyValueTransfer
     *
     * @return \Generated\Shared\Transfer\MoneyValueTransfer
     */
    protected function mapPriceProductStoreEntityToMoneyValueTransfer(
        SpyPriceProductStore $priceProductStoreEntity,
        MoneyValueTransfer $moneyValueTransfer
    ): MoneyValueTransfer {
        /** @var \Orm\Zed\Store\Persistence\SpyStore $storeEntity */
        $storeEntity = $priceProductStoreEntity->getStore();
        $moneyValueTransfer->fromArray($priceProductStoreEntity->toArray(), true);
        $moneyValueTransfer->setIdEntity((int)$priceProductStoreEntity->getIdPriceProductStore());
        $moneyValueTransfer->setGrossAmount($priceProductStoreEntity->getGrossPrice());
        $moneyValueTransfer->setNetAmount($priceProductStoreEntity->getNetPrice());
        $moneyValueTransfer->setCurrency(
            $this->mapCurrencyEntityToTransfer($priceProductStoreEntity->getCurrency(), new CurrencyTransfer()),
        );
        $moneyValueTransfer->setStore(
            $this->mapStoreEntityToStoreTransfer($storeEntity, new StoreTransfer()),
        );

        return $moneyValueTransfer;
    }

    /**
     * @param \Orm\Zed\PriceProduct\Persistence\SpyPriceType $priceTypeEntity
     * @param \Generated\Shared\Transfer\PriceTypeTransfer $priceTypeTransfer
     *
     * @return \Generated\Shared\Transfer\PriceTypeTransfer
     */
    protected function mapPriceTypeEntityToPriceTypeTransfer(
        SpyPriceType $priceTypeEntity,
        PriceTypeTransfer $priceTypeTransfer
    ): PriceTypeTransfer {
        return $priceTypeTransfer->fromArray($priceTypeEntity->toArray(), true);
    }

    /**
     * @param \Orm\Zed\Currency\Persistence\SpyCurrency $currencyEntity
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    protected function mapCurrencyEntityToTransfer(SpyCurrency $currencyEntity, CurrencyTransfer $currencyTransfer): CurrencyTransfer
    {
        return $currencyTransfer->fromArray($currencyEntity->toArray(), true);
    }

    /**
     * @param \Orm\Zed\Store\Persistence\SpyStore $storeEntity
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    protected function mapStoreEntityToStoreTransfer(SpyStore $storeEntity, StoreTransfer $storeTransfer): StoreTransfer
    {
        return $storeTransfer->fromArray($storeEntity->toArray(), true);
    }

    /**
     * @param \Orm\Zed\PriceProductOffer\Persistence\SpyPriceProductOffer $priceProductOfferEntity
     * @param \Generated\Shared\Transfer\PriceProductOfferTransfer $priceProductOfferTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductOfferTransfer
     */
    protected function mapPriceProductOfferEntityToPriceProductOfferTransfer(
        SpyPriceProductOffer $priceProductOfferEntity,
        PriceProductOfferTransfer $priceProductOfferTransfer
    ): PriceProductOfferTransfer {
        return $priceProductOfferTransfer->fromArray($priceProductOfferEntity->toArray(), true);
    }
}
