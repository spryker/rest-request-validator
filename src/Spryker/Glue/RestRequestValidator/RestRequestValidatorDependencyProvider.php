<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\RestRequestValidator;

use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;
use Spryker\Glue\RestRequestValidator\Dependency\Client\RestRequestValidatorToStoreClientBridge;
use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToConstraintCollectionAdapter;
use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapter;
use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToValidationAdapter;
use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapter;

/**
 * @method \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig getConfig()
 */
class RestRequestValidatorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const ADAPTER_FILESYSTEM = 'ADAPTER_FILESYSTEM';

    /**
     * @var string
     */
    public const ADAPTER_YAML = 'ADAPTER_YAML';

    /**
     * @var string
     */
    public const ADAPTER_VALIDATION = 'ADAPTER_VALIDATION';

    /**
     * @var string
     */
    public const ADAPTER_CONSTRAINT_COLLECTION = 'ADAPTER_CONSTRAINT_COLLECTION';

    /**
     * @var string
     */
    public const CLIENT_STORE = 'CLIENT_STORE';

    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addFilesystemAdapter($container);
        $container = $this->addYamlAdapter($container);
        $container = $this->addValidationAdapter($container);
        $container = $this->addConstraintCollectionAdapter($container);
        $container = $this->addStoreClient($container);

        return $container;
    }

    protected function addFilesystemAdapter(Container $container): Container
    {
        $container->set(static::ADAPTER_FILESYSTEM, function () {
            return new RestRequestValidatorToFilesystemAdapter();
        });

        return $container;
    }

    protected function addYamlAdapter(Container $container): Container
    {
        $container->set(static::ADAPTER_YAML, function () {
            return new RestRequestValidatorToYamlAdapter();
        });

        return $container;
    }

    protected function addStoreClient(Container $container): Container
    {
        $container->set(static::CLIENT_STORE, function (Container $container) {
            return new RestRequestValidatorToStoreClientBridge($container->getLocator()->store()->client());
        });

        return $container;
    }

    protected function addValidationAdapter(Container $container): Container
    {
        $container->set(static::ADAPTER_VALIDATION, function () {
            return new RestRequestValidatorToValidationAdapter();
        });

        return $container;
    }

    protected function addConstraintCollectionAdapter(Container $container): Container
    {
        $container->set(static::ADAPTER_CONSTRAINT_COLLECTION, function () {
            return new RestRequestValidatorToConstraintCollectionAdapter();
        });

        return $container;
    }
}
