<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\RestRequestValidator\Processor\Validator\Configuration;

use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\RestRequestValidator\Dependency\Client\RestRequestValidatorToStoreClientInterface;
use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface;
use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface;
use Spryker\Glue\RestRequestValidator\Processor\Exception\CacheFileNotFoundException;
use Spryker\Glue\RestRequestValidator\Processor\Validator\Configuration\Reader\RestRequestValidatorConfigFileReaderInterface;
use Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig;

class RestRequestValidatorConfigReader implements RestRequestValidatorConfigReaderInterface
{
    protected const EXCEPTION_MESSAGE_CACHE_FILE_NOT_FOUND = 'Validation cache is enabled, but cache file is not found.';

    /**
     * @var \Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface
     */
    protected $filesystem;

    /**
     * @var \Spryker\Glue\RestRequestValidator\Processor\Validator\Configuration\Reader\RestRequestValidatorConfigFileReaderInterface
     */
    protected $fileReader;

    /**
     * @var \Spryker\Glue\RestRequestValidator\Dependency\Client\RestRequestValidatorToStoreClientInterface
     */
    protected $storeClient;

    /**
     * @var \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig
     */
    protected $config;

    /**
     * @param \Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface $filesystem
     * @param \Spryker\Glue\RestRequestValidator\Processor\Validator\Configuration\Reader\RestRequestValidatorConfigFileReaderInterface $fileReader
     * @param \Spryker\Glue\RestRequestValidator\Dependency\Client\RestRequestValidatorToStoreClientInterface $storeClient
     * @param \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig $config
     */
    public function __construct(
        RestRequestValidatorToFilesystemAdapterInterface $filesystem,
        RestRequestValidatorConfigFileReaderInterface $fileReader,
        RestRequestValidatorToStoreClientInterface $storeClient,
        RestRequestValidatorConfig $config
    ) {
        $this->filesystem = $filesystem;
        $this->fileReader = $fileReader;
        $this->storeClient = $storeClient;
        $this->config = $config;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @throws \Spryker\Glue\RestRequestValidator\Processor\Exception\CacheFileNotFoundException
     *
     * @return array|null
     */
    public function findValidationConfiguration(RestRequestInterface $restRequest): ?array
    {
        $configuration = $this->fileReader->readConfig();

        $resourceType = $restRequest->getResource()->getType();
        $requestMethod = strtolower($restRequest->getMetadata()->getMethod());

        if (empty($configuration[$resourceType][$requestMethod])) {
            return [];
        }

        return $configuration[$resourceType][$requestMethod];
    }
}
