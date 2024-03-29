<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductOffer\Business\Validator\Constraint;

use ArrayObject;
use Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer;
use Generated\Shared\Transfer\PriceProductOfferTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductOfferTransfer;
use Spryker\Zed\Kernel\Communication\Validator\AbstractConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ValidUniqueStoreCurrencyGrossNetConstraintValidator extends AbstractConstraintValidator
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductOfferTransfer $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     *
     * @throws \Symfony\Component\Validator\Exception\UnexpectedTypeException
     *
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        $priceProductOfferTransfer = $value;
        if (!$priceProductOfferTransfer instanceof PriceProductOfferTransfer) {
            throw new UnexpectedTypeException($priceProductOfferTransfer, PriceProductOfferTransfer::class);
        }

        if (!$constraint instanceof ValidUniqueStoreCurrencyGrossNetConstraint) {
            throw new UnexpectedTypeException($constraint, ValidUniqueStoreCurrencyGrossNetConstraint::class);
        }

        $priceProductTransfers = $priceProductOfferTransfer->getProductOfferOrFail()->getPrices();

        foreach ($priceProductTransfers as $priceProductIndex => $priceProductTransfer) {
            if (!$priceProductTransfer->getPriceDimension()) {
                return;
            }

            $moneyValueTransfer = $priceProductTransfer->getMoneyValueOrFail();
            $priceDimensionTransfer = $priceProductTransfer->getPriceDimensionOrFail();
            if (
                !$priceDimensionTransfer->getIdProductOffer()
                || !$moneyValueTransfer->getFkStore()
                || !$moneyValueTransfer->getFkCurrency()
            ) {
                return;
            }

            /** @var \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer> $persistedPriceProductTransfers */
            $persistedPriceProductTransfers = $this->getProductOfferPrices(
                $priceProductTransfer,
                $constraint,
            );

            if ($persistedPriceProductTransfers->count() < 1) {
                return;
            }

            if ($persistedPriceProductTransfers->count() === 1) {
                /** @var \Generated\Shared\Transfer\PriceProductTransfer $persistedPriceProductTransfer */
                $persistedPriceProductTransfer = $persistedPriceProductTransfers->offsetGet(0);

                if ($persistedPriceProductTransfer->getMoneyValueOrFail()->getIdEntity() === $moneyValueTransfer->getIdEntity()) {
                    return;
                }
            }

            $this->context->buildViolation($constraint->getMessage())
                ->atPath($this->createViolationPath($priceProductIndex))
                ->addViolation();
        }
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param \Spryker\Zed\PriceProductOffer\Business\Validator\Constraint\ValidUniqueStoreCurrencyGrossNetConstraint $constraint
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer>
     */
    protected function getProductOfferPrices(
        PriceProductTransfer $priceProductTransfer,
        ValidUniqueStoreCurrencyGrossNetConstraint $constraint
    ): ArrayObject {
        $moneyValueTransfer = $priceProductTransfer->getMoneyValueOrFail();
        $priceDimensionTransfer = $priceProductTransfer->getPriceDimensionOrFail();

        $priceProductOfferCriteriaTransfer = (new PriceProductOfferCriteriaTransfer())
            ->setIdProductOffer($priceDimensionTransfer->getIdProductOfferOrFail())
            ->addIdCurrency($moneyValueTransfer->getFkCurrencyOrFail())
            ->addIdStore($moneyValueTransfer->getFkStoreOrFail())
            ->addIdPriceType(
                $priceProductTransfer->getPriceTypeOrFail()->getIdPriceTypeOrFail(),
            );

        return $constraint->getPriceProductOfferRepository()
            ->getProductOfferPrices($priceProductOfferCriteriaTransfer);
    }

    /**
     * @param int $priceProductIndex
     *
     * @return string
     */
    protected function createViolationPath(int $priceProductIndex): string
    {
        return sprintf(
            '[%s][%s][%d]',
            PriceProductOfferTransfer::PRODUCT_OFFER,
            ProductOfferTransfer::PRICES,
            $priceProductIndex,
        );
    }
}
