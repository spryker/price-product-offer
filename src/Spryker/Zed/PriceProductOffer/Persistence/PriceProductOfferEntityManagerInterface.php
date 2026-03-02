<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductOffer\Persistence;

use Generated\Shared\Transfer\PriceProductOfferCriteriaTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;

interface PriceProductOfferEntityManagerInterface
{
    public function createPriceProductOfferRelation(PriceProductTransfer $priceProductTransfer): PriceProductTransfer;

    public function updatePriceProductOfferRelation(PriceProductTransfer $priceProductTransfer): PriceProductTransfer;

    public function delete(PriceProductOfferCriteriaTransfer $priceProductOfferCriteriaTransfer): void;
}
