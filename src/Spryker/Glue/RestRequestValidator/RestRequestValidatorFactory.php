<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\RestRequestValidator;

use Spryker\Glue\GlueApplication\Rest\Request\RestRequestValidatorInterface;
use Spryker\Glue\Kernel\AbstractFactory;
use Spryker\Glue\RestRequestValidator\Dependency\Client\RestRequestValidatorToStoreClientInterface;
use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToConstraintCollectionAdapterInterface;
use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface;
use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToValidationAdapterInterface;
use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface;
use Spryker\Glue\RestRequestValidator\Processor\Validator\Configuration\RestRequestValidatorConfigReader;
use Spryker\Glue\RestRequestValidator\Processor\Validator\Configuration\RestRequestValidatorConfigReaderInterface;
use Spryker\Glue\RestRequestValidator\Processor\Validator\Constraint\RestRequestValidatorConstraintResolver;
use Spryker\Glue\RestRequestValidator\Processor\Validator\Constraint\RestRequestValidatorConstraintResolverInterface;
use Spryker\Glue\RestRequestValidator\Processor\Validator\RestRequestValidator;

/**
 * @method \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig getConfig()
 */
class RestRequestValidatorFactory extends AbstractFactory
{
    public function createRestRequestValidator(): RestRequestValidatorInterface
    {
        return new RestRequestValidator(
            $this->createRestRequestValidatorConstraintResolver(),
            $this->getValidatorAdapter(),
            $this->getConfig(),
        );
    }

    public function createRestRequestValidatorConfigReader(): RestRequestValidatorConfigReaderInterface
    {
        return new RestRequestValidatorConfigReader(
            $this->getFilesystemAdapter(),
            $this->getYamlAdapter(),
            $this->getStoreClient(),
            $this->getConfig(),
        );
    }

    public function createRestRequestValidatorConstraintResolver(): RestRequestValidatorConstraintResolverInterface
    {
        return new RestRequestValidatorConstraintResolver(
            $this->getConstraintCollectionAdapter(),
            $this->createRestRequestValidatorConfigReader(),
            $this->getConfig(),
        );
    }

    public function getFilesystemAdapter(): RestRequestValidatorToFilesystemAdapterInterface
    {
        return $this->getProvidedDependency(RestRequestValidatorDependencyProvider::ADAPTER_FILESYSTEM);
    }

    public function getYamlAdapter(): RestRequestValidatorToYamlAdapterInterface
    {
        return $this->getProvidedDependency(RestRequestValidatorDependencyProvider::ADAPTER_YAML);
    }

    public function getValidatorAdapter(): RestRequestValidatorToValidationAdapterInterface
    {
        return $this->getProvidedDependency(RestRequestValidatorDependencyProvider::ADAPTER_VALIDATION);
    }

    public function getConstraintCollectionAdapter(): RestRequestValidatorToConstraintCollectionAdapterInterface
    {
        return $this->getProvidedDependency(RestRequestValidatorDependencyProvider::ADAPTER_CONSTRAINT_COLLECTION);
    }

    public function getStoreClient(): RestRequestValidatorToStoreClientInterface
    {
        return $this->getProvidedDependency(RestRequestValidatorDependencyProvider::CLIENT_STORE);
    }
}
