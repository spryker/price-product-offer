<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductOffer\Business\Validator\Constraint;

use Symfony\Component\Validator\Constraints\AbstractComparison;

class GreaterThanOrEqualOrEmptyConstraint extends AbstractComparison
{
    /**
     * @var string
     */
    public $message = 'This value should be equal or greater than {{ compared_value }} or empty.';

    /**
     * @return string
     */
    public function getTargets(): string
    {
        return static::CLASS_CONSTRAINT;
    }
}
