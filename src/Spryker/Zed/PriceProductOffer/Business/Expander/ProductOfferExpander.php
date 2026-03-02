<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductOffer\Business\Expander;

use Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer;
use Generated\Shared\Transfer\ProductOfferTransfer;
use Spryker\Zed\PriceProductOffer\Business\Reader\PriceProductOfferReaderInterface;

class ProductOfferExpander implements ProductOfferExpanderInterface
{
    /**
     * @var \Spryker\Zed\PriceProductOffer\Business\Reader\PriceProductOfferReaderInterface
     */
    protected $priceProductOfferReader;

    public function __construct(PriceProductOfferReaderInterface $priceProductOfferReader)
    {
        $this->priceProductOfferReader = $priceProductOfferReader;
    }

    public function expandProductOfferWithPrices(ProductOfferTransfer $productOfferTransfer): ProductOfferTransfer
    {
        $productOfferTransfer->requireIdProductOffer();

        $productOfferTransfer->setPrices(
            $this->priceProductOfferReader->getProductOfferPrices(
                (new PriceProductOfferCriteriaTransfer())
                    ->setIdProductOffer($productOfferTransfer->getIdProductOffer())
                    ->setWithExtractedPrices(false),
            ),
        );

        return $productOfferTransfer;
    }
}
