<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PersistentCartShare\Communication\Plugin;

use Generated\Shared\Transfer\ResourceShareTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PersistentCartShare\PersistentCartShareConfig;
use Spryker\Zed\ResourceShareExtension\Dependency\Plugin\ResourceShareActivatorStrategyPluginInterface;

/**
 * @method \Spryker\Zed\PersistentCartShare\Business\PersistentCartShareFacade getFacade()
 * @method \Spryker\Zed\PersistentCartShare\PersistentCartShareConfig getConfig()
 */
class CartPreviewActivatorStrategyPlugin extends AbstractPlugin implements ResourceShareActivatorStrategyPluginInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return bool
     */
    public function isLoginRequired(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     * - Returns 'true', when resource type is Quote, and share option is Preview.
     * - Returns 'false' otherwise.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ResourceShareTransfer $resourceShareTransfer
     *
     * @return bool
     */
    public function isApplicable(ResourceShareTransfer $resourceShareTransfer): bool
    {
        if ($resourceShareTransfer->getResourceType() !== PersistentCartShareConfig::RESOURCE_TYPE_QUOTE) {
            return false;
        }

        $resourceShareTransfer->requireResourceShareData();
        $resourceShareDataTransfer = $resourceShareTransfer->getResourceShareData();
        $resourceShareData = $resourceShareDataTransfer->getData();

        if (!isset($resourceShareData[PersistentCartShareConfig::KEY_ID_QUOTE], $resourceShareData[PersistentCartShareConfig::KEY_SHARE_OPTION])
            || $resourceShareData[PersistentCartShareConfig::KEY_SHARE_OPTION] !== PersistentCartShareConfig::SHARE_OPTION_PREVIEW
        ) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     * - Does nothing, as no additional actions required for cart preview.
     *
     * @api
     *
     * @return void
     */
    public function execute(ResourceShareTransfer $resourceShareTransfer): void
    {
    }
}
