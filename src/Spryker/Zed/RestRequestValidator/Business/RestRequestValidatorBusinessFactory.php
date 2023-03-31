<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\RestRequestValidator\Business\Builder\RestRequestValidatorCacheBuilder;
use Spryker\Zed\RestRequestValidator\Business\Builder\RestRequestValidatorCacheBuilderInterface;
use Spryker\Zed\RestRequestValidator\Business\Builder\RestRequestValidatorCodeBucketCacheBuilder;
use Spryker\Zed\RestRequestValidator\Business\Builder\RestRequestValidatorCodeBucketCacheBuilderInterface;
use Spryker\Zed\RestRequestValidator\Business\Collector\RestRequestValidatorCacheCollector;
use Spryker\Zed\RestRequestValidator\Business\Collector\RestRequestValidatorCacheCollectorInterface;
use Spryker\Zed\RestRequestValidator\Business\Collector\SchemaFinder\RestRequestValidatorSchemaFinder;
use Spryker\Zed\RestRequestValidator\Business\Collector\SchemaFinder\RestRequestValidatorSchemaFinderInterface;
use Spryker\Zed\RestRequestValidator\Business\Merger\RestRequestValidatorSchemaMerger;
use Spryker\Zed\RestRequestValidator\Business\Merger\RestRequestValidatorSchemaMergerInterface;
use Spryker\Zed\RestRequestValidator\Business\Remover\RestRequestValidatorCacheRemover;
use Spryker\Zed\RestRequestValidator\Business\Remover\RestRequestValidatorCacheRemoverInterface;
use Spryker\Zed\RestRequestValidator\Business\Remover\RestRequestValidatorCodeBucketCacheRemover;
use Spryker\Zed\RestRequestValidator\Business\Remover\RestRequestValidatorCodeBucketCacheRemoverInterface;
use Spryker\Zed\RestRequestValidator\Business\Saver\RestRequestValidatorCacheSaver;
use Spryker\Zed\RestRequestValidator\Business\Saver\RestRequestValidatorCacheSaverInterface;
use Spryker\Zed\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface;
use Spryker\Zed\RestRequestValidator\Dependency\External\RestRequestValidatorToFinderAdapterInterface;
use Spryker\Zed\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface;
use Spryker\Zed\RestRequestValidator\Dependency\Facade\RestRequestValidatorToKernelFacadeInterface;
use Spryker\Zed\RestRequestValidator\Dependency\Facade\RestRequestValidatorToStoreFacadeInterface;
use Spryker\Zed\RestRequestValidator\Dependency\Store\RestRequestValidatorToStoreInterface;
use Spryker\Zed\RestRequestValidator\RestRequestValidatorDependencyProvider;

/**
 * @method \Spryker\Zed\RestRequestValidator\RestRequestValidatorConfig getConfig()
 */
class RestRequestValidatorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @deprecated Use {@link \Spryker\Zed\RestRequestValidator\Business\RestRequestValidatorBusinessFactory::createRestRequestValidatorCodeBucketCacheBuilder()} instead.
     *
     * @return \Spryker\Zed\RestRequestValidator\Business\Builder\RestRequestValidatorCacheBuilderInterface
     */
    public function createRestRequestValidatorCacheBuilder(): RestRequestValidatorCacheBuilderInterface
    {
        return new RestRequestValidatorCacheBuilder(
            $this->createRestRequestValidatorCacheCollector(),
            $this->createRestRequestValidatorSchemaMerger(),
            $this->createRestRequestValidatorCacheSaver(),
            $this->getStoreFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Business\Builder\RestRequestValidatorCodeBucketCacheBuilderInterface
     */
    public function createRestRequestValidatorCodeBucketCacheBuilder(): RestRequestValidatorCodeBucketCacheBuilderInterface
    {
        return new RestRequestValidatorCodeBucketCacheBuilder(
            $this->createRestRequestValidatorCacheCollector(),
            $this->createRestRequestValidatorSchemaMerger(),
            $this->createRestRequestValidatorCacheSaver(),
        );
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Business\Collector\RestRequestValidatorCacheCollectorInterface
     */
    public function createRestRequestValidatorCacheCollector(): RestRequestValidatorCacheCollectorInterface
    {
        return new RestRequestValidatorCacheCollector(
            $this->createRestRequestValidatorSchemaFinder(),
            $this->getFilesystemAdapter(),
            $this->getYamlAdapter(),
        );
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Business\Merger\RestRequestValidatorSchemaMergerInterface
     */
    public function createRestRequestValidatorSchemaMerger(): RestRequestValidatorSchemaMergerInterface
    {
        return new RestRequestValidatorSchemaMerger();
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Business\Saver\RestRequestValidatorCacheSaverInterface
     */
    public function createRestRequestValidatorCacheSaver(): RestRequestValidatorCacheSaverInterface
    {
        return new RestRequestValidatorCacheSaver(
            $this->getFilesystemAdapter(),
            $this->getYamlAdapter(),
            $this->getConfig(),
        );
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Business\Collector\SchemaFinder\RestRequestValidatorSchemaFinderInterface
     */
    public function createRestRequestValidatorSchemaFinder(): RestRequestValidatorSchemaFinderInterface
    {
        return new RestRequestValidatorSchemaFinder(
            $this->getFinderAdapter(),
            $this->getConfig(),
            $this->getKernelFacade(),
            $this->getStoreFacade(),
        );
    }

    /**
     * @deprecated Use {@link \Spryker\Zed\RestRequestValidator\Business\RestRequestValidatorBusinessFactory::createRestRequestValidatorCodeBucketCacheRemover()} instead.
     *
     * @return \Spryker\Zed\RestRequestValidator\Business\Remover\RestRequestValidatorCacheRemoverInterface
     */
    public function createRestRequestValidatorCacheRemover(): RestRequestValidatorCacheRemoverInterface
    {
        return new RestRequestValidatorCacheRemover(
            $this->getStore(),
            $this->getFilesystemAdapter(),
            $this->getConfig(),
        );
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Business\Remover\RestRequestValidatorCodeBucketCacheRemoverInterface
     */
    public function createRestRequestValidatorCodeBucketCacheRemover(): RestRequestValidatorCodeBucketCacheRemoverInterface
    {
        return new RestRequestValidatorCodeBucketCacheRemover(
            $this->getFilesystemAdapter(),
            $this->getConfig(),
        );
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Dependency\External\RestRequestValidatorToFinderAdapterInterface
     */
    public function getFinderAdapter(): RestRequestValidatorToFinderAdapterInterface
    {
        return $this->getProvidedDependency(RestRequestValidatorDependencyProvider::ADAPTER_FINDER);
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface
     */
    public function getFilesystemAdapter(): RestRequestValidatorToFilesystemAdapterInterface
    {
        return $this->getProvidedDependency(RestRequestValidatorDependencyProvider::ADAPTER_FILESYSTEM);
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface
     */
    public function getYamlAdapter(): RestRequestValidatorToYamlAdapterInterface
    {
        return $this->getProvidedDependency(RestRequestValidatorDependencyProvider::ADAPTER_YAML);
    }

    /**
     * @deprecated Use {@link \Spryker\Zed\RestRequestValidator\Business\RestRequestValidatorBusinessFactory::getStoreFacade()} instead.
     *
     * @return \Spryker\Zed\RestRequestValidator\Dependency\Store\RestRequestValidatorToStoreInterface
     */
    public function getStore(): RestRequestValidatorToStoreInterface
    {
        return $this->getProvidedDependency(RestRequestValidatorDependencyProvider::STORE);
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Dependency\Facade\RestRequestValidatorToStoreFacadeInterface
     */
    public function getStoreFacade(): RestRequestValidatorToStoreFacadeInterface
    {
        return $this->getProvidedDependency(RestRequestValidatorDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Dependency\Facade\RestRequestValidatorToKernelFacadeInterface
     */
    public function getKernelFacade(): RestRequestValidatorToKernelFacadeInterface
    {
        return $this->getProvidedDependency(RestRequestValidatorDependencyProvider::FACADE_KERNEL);
    }
}
