<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductAlternativeProductLabelConnector\Persistence;

interface ProductAlternativeProductLabelConnectorRepositoryInterface
{
    /**
     * @return int[]
     */
    public function getProductAbstractIdsForAlternative(): array;
}
