<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListStorage;

use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Orm\Zed\ShoppingList\Persistence\SpyShoppingListQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ShoppingListStorage\Dependency\Facade\ShoppingListStorageToCompanyBusinessUnitFacadeBridge;
use Spryker\Zed\ShoppingListStorage\Dependency\Facade\ShoppingListStorageToCompanyUserFacadeBridge;
use Spryker\Zed\ShoppingListStorage\Dependency\Facade\ShoppingListStorageToEventBehaviorFacadeBridge;

class ShoppingListStorageDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';
    public const FACADE_COMPANY_USER = 'FACADE_COMPANY_USER';
    public const FACADE_COMPANY_BUSINESS_UNIT = 'FACADE_COMPANY_BUSINESS_UNIT';
    public const PROPEL_QUERY_SHOPPING_LIST = 'PROPEL_QUERY_SHOPPING_LIST';
    public const PROPEL_QUERY_COMPANY_USER = 'PROPEL_QUERY_COMPANY_USER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container[static::FACADE_EVENT_BEHAVIOR] = function (Container $container) {
            return new ShoppingListStorageToEventBehaviorFacadeBridge($container->getLocator()->eventBehavior()->facade());
        };

        $container[static::FACADE_COMPANY_USER] = function (Container $container) {
            return new ShoppingListStorageToCompanyUserFacadeBridge($container->getLocator()->companyUser()->facade());
        };

        $container[static::FACADE_COMPANY_BUSINESS_UNIT] = function (Container $container) {
            return new ShoppingListStorageToCompanyBusinessUnitFacadeBridge($container->getLocator()->companyBusinessUnit()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container)
    {
        $container = parent::providePersistenceLayerDependencies($container);

        $container[static::PROPEL_QUERY_SHOPPING_LIST] = function (Container $container) {
            return new SpyShoppingListQuery();
        };

        $container[static::PROPEL_QUERY_COMPANY_USER] = function (Container $container) {
            return new SpyCompanyUserQuery();
        };

        return $container;
    }
}
