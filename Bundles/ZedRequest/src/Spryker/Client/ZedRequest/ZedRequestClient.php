<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ZedRequest;

use Generated\Shared\Transfer\HealthCheckServiceResponseTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Client\Kernel\AbstractClient;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

/**
 * @method \Spryker\Client\ZedRequest\ZedRequestFactory getFactory()
 */
class ZedRequestClient extends AbstractClient implements ZedRequestClientInterface
{
    /**
     * @return \Spryker\Client\ZedRequest\Client\ZedClient|\Spryker\Shared\ZedRequest\Client\AbstractZedClientInterface
     */
    private function getClient()
    {
        return $this->getFactory()
            ->getCashedClient();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $url
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $object
     * @param array|int|null $requestOptions
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function call($url, TransferInterface $object, $requestOptions = null)
    {
        $localeName = Store::getInstance()->getCurrentLocale();
        $localeTransfer = new LocaleTransfer();
        $localeTransfer->setLocaleName($localeName);

        $this->getClient()->addMetaTransfer('locale', $localeTransfer);

        $this->applyMetaData($object);

        return $this->getClient()->call($url, $object, $requestOptions);
    }

    /**
     * @api
     *
     * @return \Generated\Shared\Transfer\MessageTransfer[]
     */
    public function getLastResponseInfoMessages()
    {
        return $this->getFactory()
            ->createMessenger()
            ->getLastResponseInfoMessages();
    }

    /**
     * @api
     *
     * @return \Generated\Shared\Transfer\MessageTransfer[]
     */
    public function getLastResponseErrorMessages()
    {
        return $this->getFactory()
            ->createMessenger()
            ->getLastResponseErrorMessages();
    }

    /**
     * @api
     *
     * @return \Generated\Shared\Transfer\MessageTransfer[]
     */
    public function getLastResponseSuccessMessages()
    {
        return $this->getFactory()
            ->createMessenger()
            ->getLastResponseSuccessMessages();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function addFlashMessagesFromLastZedRequest()
    {
        $this->getFactory()
            ->createMessenger()
            ->addFlashMessagesFromLastZedRequest();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\MessageTransfer[]
     */
    public function getResponsesInfoMessages(): array
    {
        return $this->getFactory()
            ->createMessenger()
            ->getResponsesInfoMessages();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\MessageTransfer[]
     */
    public function getResponsesErrorMessages(): array
    {
        return $this->getFactory()
            ->createMessenger()
            ->getResponsesErrorMessages();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\MessageTransfer[]
     */
    public function getResponsesSuccessMessages(): array
    {
        return $this->getFactory()
            ->createMessenger()
            ->getResponsesSuccessMessages();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function addResponseMessagesToMessenger(): void
    {
        $this->getFactory()
            ->createMessenger()
            ->addResponseMessagesToMessenger();
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $requestTransfer
     *
     * @return void
     */
    protected function applyMetaData(TransferInterface $requestTransfer)
    {
        $plugins = $this->getFactory()->getMetaDataProviderPlugins();

        foreach ($plugins as $key => $plugin) {
            $this->getClient()->addMetaTransfer(
                $key,
                $plugin->getRequestMetaData($requestTransfer)
            );
        }
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\HealthCheckServiceResponseTransfer
     */
    public function executeZedRequestHealthCheck(): HealthCheckServiceResponseTransfer
    {
        return $this->getFactory()->createZedRequestHealthCheckIndicator()->executeHealthCheck();
    }
}
