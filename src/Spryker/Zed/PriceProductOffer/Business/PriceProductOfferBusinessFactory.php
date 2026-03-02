<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProductOffer\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\PriceProductOffer\Business\Deleter\PriceProductOfferDeleter;
use Spryker\Zed\PriceProductOffer\Business\Deleter\PriceProductOfferDeleterInterface;
use Spryker\Zed\PriceProductOffer\Business\Expander\ProductOfferExpander;
use Spryker\Zed\PriceProductOffer\Business\Expander\ProductOfferExpanderInterface;
use Spryker\Zed\PriceProductOffer\Business\Expander\Wishlist\PriceProductOfferWishlistExpander;
use Spryker\Zed\PriceProductOffer\Business\Expander\Wishlist\PriceProductOfferWishlistExpanderInterface;
use Spryker\Zed\PriceProductOffer\Business\Reader\PriceProductOfferReader;
use Spryker\Zed\PriceProductOffer\Business\Reader\PriceProductOfferReaderInterface;
use Spryker\Zed\PriceProductOffer\Business\Validator\Constraint\ValidCurrencyAssignedToStoreConstraint;
use Spryker\Zed\PriceProductOffer\Business\Validator\Constraint\ValidUniqueStoreCurrencyGrossNetConstraint;
use Spryker\Zed\PriceProductOffer\Business\Validator\PriceProductConstraintProvider;
use Spryker\Zed\PriceProductOffer\Business\Validator\PriceProductConstraintProviderInterface;
use Spryker\Zed\PriceProductOffer\Business\Validator\PriceProductOfferConstraintProvider;
use Spryker\Zed\PriceProductOffer\Business\Validator\PriceProductOfferConstraintProviderInterface;
use Spryker\Zed\PriceProductOffer\Business\Validator\PriceProductOfferValidator;
use Spryker\Zed\PriceProductOffer\Business\Validator\PriceProductOfferValidatorInterface;
use Spryker\Zed\PriceProductOffer\Business\Writer\PriceProductOfferWriter;
use Spryker\Zed\PriceProductOffer\Business\Writer\PriceProductOfferWriterInterface;
use Spryker\Zed\PriceProductOffer\Dependency\External\PriceProductOfferToValidationAdapterInterface;
use Spryker\Zed\PriceProductOffer\Dependency\Facade\PriceProductOfferToPriceProductFacadeInterface;
use Spryker\Zed\PriceProductOffer\Dependency\Facade\PriceProductOfferToStoreFacadeInterface;
use Spryker\Zed\PriceProductOffer\Dependency\Facade\PriceProductOfferToTranslatorFacadeInterface;
use Spryker\Zed\PriceProductOffer\PriceProductOfferDependencyProvider;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

/**
 * @method \Spryker\Zed\PriceProductOffer\Persistence\PriceProductOfferEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\PriceProductOffer\Persistence\PriceProductOfferRepositoryInterface getRepository()
 * @method \Spryker\Zed\PriceProductOffer\PriceProductOfferConfig getConfig()
 */
class PriceProductOfferBusinessFactory extends AbstractBusinessFactory
{
    public function createPriceProductOfferWriter(): PriceProductOfferWriterInterface
    {
        return new PriceProductOfferWriter(
            $this->getPriceProductFacade(),
            $this->getEntityManager(),
            $this->getRepository(),
        );
    }

    public function createPriceProductOfferDeleter(): PriceProductOfferDeleterInterface
    {
        return new PriceProductOfferDeleter(
            $this->getEntityManager(),
        );
    }

    public function createProductOfferExpander(): ProductOfferExpanderInterface
    {
        return new ProductOfferExpander($this->createPriceProductOfferReader());
    }

    public function createPriceProductOfferValidator(): PriceProductOfferValidatorInterface
    {
        return new PriceProductOfferValidator(
            $this->createPriceProductOfferConstraintProvider(),
            $this->createPriceProductConstraintProvider(),
            $this->getValidationAdapter(),
            $this->getPriceProductOfferValidatorPlugins(),
            $this->getTranslatorFacade(),
        );
    }

    /**
     * @return array<\Symfony\Component\Validator\Constraint>
     */
    public function getPriceProductOfferValidatorConstraints(): array
    {
        return [
            $this->createValidCurrencyAssignedToStoreConstraint(),
            $this->createValidUniqueStoreCurrencyGrossNetPriceDataConstraint(),
        ];
    }

    public function createPriceProductOfferConstraintProvider(): PriceProductOfferConstraintProviderInterface
    {
        return new PriceProductOfferConstraintProvider(
            $this->getPriceProductOfferValidatorConstraints(),
        );
    }

    public function createPriceProductConstraintProvider(): PriceProductConstraintProviderInterface
    {
        return new PriceProductConstraintProvider();
    }

    public function createPriceProductOfferReader(): PriceProductOfferReaderInterface
    {
        return new PriceProductOfferReader(
            $this->getRepository(),
            $this->getPriceProductOfferExtractorPlugins(),
            $this->getPriceProductOfferExpanderPlugins(),
        );
    }

    public function createPriceProductOfferWishlistExpander(): PriceProductOfferWishlistExpanderInterface
    {
        return new PriceProductOfferWishlistExpander(
            $this->createPriceProductOfferReader(),
            $this->getStoreFacade(),
        );
    }

    public function getPriceProductFacade(): PriceProductOfferToPriceProductFacadeInterface
    {
        return $this->getProvidedDependency(PriceProductOfferDependencyProvider::FACADE_PRICE_PRODUCT);
    }

    public function createValidUniqueStoreCurrencyGrossNetPriceDataConstraint(): SymfonyConstraint
    {
        return new ValidUniqueStoreCurrencyGrossNetConstraint($this->getRepository());
    }

    public function createValidCurrencyAssignedToStoreConstraint(): SymfonyConstraint
    {
        return new ValidCurrencyAssignedToStoreConstraint(
            $this->getStoreFacade(),
        );
    }

    public function getStoreFacade(): PriceProductOfferToStoreFacadeInterface
    {
        return $this->getProvidedDependency(PriceProductOfferDependencyProvider::FACADE_STORE);
    }

    public function getValidationAdapter(): PriceProductOfferToValidationAdapterInterface
    {
        return $this->getProvidedDependency(PriceProductOfferDependencyProvider::EXTERNAL_ADAPTER_VALIDATION);
    }

    /**
     * @return array<\Spryker\Zed\PriceProductOfferExtension\Dependency\Plugin\PriceProductOfferExtractorPluginInterface>
     */
    public function getPriceProductOfferExtractorPlugins(): array
    {
        return $this->getProvidedDependency(PriceProductOfferDependencyProvider::PLUGINS_PRICE_PRODUCT_OFFER_EXTRACTOR);
    }

    /**
     * @return array<\Spryker\Zed\PriceProductOfferExtension\Dependency\Plugin\PriceProductOfferExpanderPluginInterface>
     */
    public function getPriceProductOfferExpanderPlugins(): array
    {
        return $this->getProvidedDependency(PriceProductOfferDependencyProvider::PLUGINS_PRICE_PRODUCT_OFFER_EXPANDER);
    }

    /**
     * @return array<\Spryker\Zed\PriceProductOfferExtension\Dependency\Plugin\PriceProductOfferValidatorPluginInterface>
     */
    public function getPriceProductOfferValidatorPlugins(): array
    {
        return $this->getProvidedDependency(PriceProductOfferDependencyProvider::PLUGINS_PRICE_PRODUCT_OFFER_VALIDATOR);
    }

    public function getTranslatorFacade(): PriceProductOfferToTranslatorFacadeInterface
    {
        return $this->getProvidedDependency(PriceProductOfferDependencyProvider::FACADE_TRANSLATOR);
    }
}
