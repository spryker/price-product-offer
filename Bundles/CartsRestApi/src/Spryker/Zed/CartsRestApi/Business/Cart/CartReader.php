<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CartsRestApi\Business\Cart;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestQuoteCollectionRequestTransfer;
use Generated\Shared\Transfer\RestQuoteCollectionResponseTransfer;
use Spryker\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface;

class CartReader implements CartReaderInterface
{
    /**
     * @var \Spryker\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface
     */
    protected $quoteFacade;

    /**
     * @param \Spryker\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface $quoteFacade
     */
    public function __construct(CartsRestApiToQuoteFacadeInterface $quoteFacade)
    {
        $this->quoteFacade = $quoteFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function findQuoteByUuid(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        return $this->quoteFacade->findQuoteByUuid($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestQuoteCollectionRequestTransfer $restQuoteCollectionRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestQuoteCollectionResponseTransfer
     */
    public function findCustomerQuoteCollection(
        RestQuoteCollectionRequestTransfer $restQuoteCollectionRequestTransfer
    ): RestQuoteCollectionResponseTransfer {
        $restQuoteCollectionResponseTransfer = new RestQuoteCollectionResponseTransfer();
        $quoteCollectionTransfer = $this->getCustomerQuotes($restQuoteCollectionRequestTransfer);
        if (count($quoteCollectionTransfer->getQuotes()) === 0) {
            return $restQuoteCollectionResponseTransfer;
        }

        return $restQuoteCollectionResponseTransfer->setQuoteCollection($quoteCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestQuoteCollectionRequestTransfer $restQuoteCollectionRequestTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected function getCustomerQuotes(RestQuoteCollectionRequestTransfer $restQuoteCollectionRequestTransfer): QuoteCollectionTransfer
    {
        $quoteCriteriaFilterTransfer = new QuoteCriteriaFilterTransfer();
        $quoteCriteriaFilterTransfer->setCustomerReference($restQuoteCollectionRequestTransfer->getCustomerReference());
        $quoteCollectionTransfer = $this->quoteFacade->getQuoteCollection($quoteCriteriaFilterTransfer);

        return $quoteCollectionTransfer;
    }
}
