<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductOffer\Business\Constraint;

use Spryker\Zed\PriceProductOffer\Persistence\PriceProductOfferRepositoryInterface;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

class ValidUniqueStoreCurrencyGrossNetPriceDataConstraint extends SymfonyConstraint
{
    protected const MESSAGE = 'Data is duplicated';

    /**
     * @var \Spryker\Zed\PriceProductOffer\Persistence\PriceProductOfferRepositoryInterface
     */
    protected $priceProductOfferRepository;

    /**
     * @param \Spryker\Zed\PriceProductOffer\Persistence\PriceProductOfferRepositoryInterface $priceProductOfferRepository
     * @param array|null $options
     */
    public function __construct(PriceProductOfferRepositoryInterface $priceProductOfferRepository, $options = null)
    {
        $this->priceProductOfferRepository = $priceProductOfferRepository;

        parent::__construct($options);
    }

    /**
     * @return \Spryker\Zed\PriceProductOffer\Persistence\PriceProductOfferRepositoryInterface
     */
    public function getPriceProductOfferRepository(): PriceProductOfferRepositoryInterface
    {
        return $this->priceProductOfferRepository;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return static::MESSAGE;
    }

    /**
     * @return string
     */
    public function getTargets(): string
    {
        return static::CLASS_CONSTRAINT;
    }
}
