<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShipmentCheckoutConnector\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;
use Spryker\Zed\ShipmentCheckoutConnector\ShipmentCheckoutConnectorDependencyProvider;

class ShipmentCheckoutConnectorQueryContainer extends AbstractQueryContainer implements ShipmentCheckoutConnectorQueryContainerInterface
{

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderQuery
     */
    public function querySalesOrderById($idSalesOrder)
    {
        return $this->getSalesQueryContainer()->querySalesOrderById($idSalesOrder);
    }

    /**
     * @api
     *
     * @param int $idShipmentMethod
     *
     * @return \Orm\Zed\Shipment\Persistence\SpyShipmentMethodQuery
     */
    public function queryShipmentOrderById($idShipmentMethod)
    {
        return $this->getShipmentQueryContainer()->queryMethodByIdMethod($idShipmentMethod);
    }

    /**
     * @return \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface
     */
    protected function getSalesQueryContainer()
    {
        return $this->getProvidedDependency(ShipmentCheckoutConnectorDependencyProvider::QUERY_CONTAINER_SALES);
    }

    /**
     * @return \Spryker\Zed\Shipment\Persistence\ShipmentQueryContainerInterface
     */
    protected function getShipmentQueryContainer()
    {
        return $this->getProvidedDependency(ShipmentCheckoutConnectorDependencyProvider::QUERY_CONTAINER_SHIPMENT);
    }

}
