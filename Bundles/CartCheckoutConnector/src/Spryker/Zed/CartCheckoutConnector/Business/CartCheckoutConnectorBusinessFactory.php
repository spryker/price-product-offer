<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CartCheckoutConnector\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\CartCheckoutConnector\CartCheckoutConnectorConfig getConfig()
 */
class CartCheckoutConnectorBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return \Spryker\Zed\CartCheckoutConnector\Business\CartOrderHydrator
     */
    public function createCartOrderHydrator()
    {
        return new CartOrderHydrator();
    }

}
