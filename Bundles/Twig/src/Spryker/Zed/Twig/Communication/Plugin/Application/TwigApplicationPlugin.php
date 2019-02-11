<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Twig\Communication\Plugin\Application;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\ApplicationExtension\Dependency\Plugin\ApplicationPluginInterface;
use Spryker\Shared\Twig\Loader\TwigChainLoaderInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Twig\Environment;

/**
 * @method \Spryker\Zed\Twig\Communication\TwigCommunicationFactory getFactory()
 * @method \Spryker\Zed\Twig\TwigConfig getConfig()
 * @method \Spryker\Zed\Twig\Business\TwigFacade getFacade()
 */
class TwigApplicationPlugin extends AbstractPlugin implements ApplicationPluginInterface
{
    protected const SERVICE_TWIG = 'twig';
    //@todo Delete it before PR to epic master. Left just to make sure that application works until we nove all twig service providers.
    protected const SERVICE_TWIG_GLOBAL_VARIABLES = 'twig.global.variables';

    protected const SERVICE_DEBUG = 'debug';

    protected const SERVICE_CHARSET = 'charset';

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    public function provide(ContainerInterface $container): ContainerInterface
    {
        $container = $this->addTwigGlobalVariables($container);
        $container = $this->addTwigService($container);

        return $container;
    }

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    protected function addTwigService(ContainerInterface $container): ContainerInterface
    {
        $container->set(static::SERVICE_TWIG, function (ContainerInterface $container) {
            $twigChainLoader = $this->getTwigChainLoader();
            $twigOptions = $this->getTwigOptions($container);
            $twig = new Environment($twigChainLoader, $twigOptions);
            $twig->addGlobal('app', $container);

            //@todo Delete it before PR to epic master. Left just to make sure that application works until we nove all twig service providers.
            $twigGlobalVariables = $container->get(static::SERVICE_TWIG_GLOBAL_VARIABLES);
            foreach ($twigGlobalVariables as $name => $value) {
                $twig->addGlobal($name, $value);
            }

            $twig = $this->extendTwig($twig, $container);

            return $twig;
        });

        return $container;
    }

    /**
     * @return \Spryker\Shared\Twig\Loader\TwigChainLoaderInterface
     */
    protected function getTwigChainLoader(): TwigChainLoaderInterface
    {
        return $this->getFactory()->createTwigChainLoader();
    }

    /**
     * @param \Twig\Environment $twig
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Twig\Environment
     */
    protected function extendTwig(Environment $twig, ContainerInterface $container): Environment
    {
        $twigPlugins = $this->getFactory()->getTwigPlugins();
        foreach ($twigPlugins as $twigPlugin) {
            $twig = $twigPlugin->extend($twig, $container);
        }

        return $twig;
    }

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return array
     */
    protected function getTwigOptions(ContainerInterface $container): array
    {
        $isDebugOn = $container->get(static::SERVICE_DEBUG);
        $twigOptions = $this->getConfig()->getTwigOptions();
        $globalOptions = [
            'charset' => $container->get(static::SERVICE_CHARSET),
            'debug' => $isDebugOn,
            'strict_variables' => $isDebugOn,
        ];

        return array_replace($globalOptions, $twigOptions);
    }

    /**
     * @todo Delete it before PR to epic master. Left just to make sure that application works until we nove all twig service providers.
     *
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    protected function addTwigGlobalVariables(ContainerInterface $container): ContainerInterface
    {
        $container->set(static::SERVICE_TWIG_GLOBAL_VARIABLES, function (ContainerInterface $container) {
            return [];
        });

        return $container;
    }
}
