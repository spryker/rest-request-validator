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
use Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig;

class RestRequestValidatorConfigReader implements RestRequestValidatorConfigReaderInterface
{
    /**
     * @var string
     */
    protected const EXCEPTION_MESSAGE_CACHE_FILE_NOT_FOUND = 'Validation cache is enabled, but cache file is not found.';

    /**
     * @var \Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface
     */
    protected $filesystem;

    /**
     * @var \Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface
     */
    protected $yaml;

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
     * @param \Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface $yaml
     * @param \Spryker\Glue\RestRequestValidator\Dependency\Client\RestRequestValidatorToStoreClientInterface $storeClient
     * @param \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig $config
     */
    public function __construct(
        RestRequestValidatorToFilesystemAdapterInterface $filesystem,
        RestRequestValidatorToYamlAdapterInterface $yaml,
        RestRequestValidatorToStoreClientInterface $storeClient,
        RestRequestValidatorConfig $config
    ) {
        $this->filesystem = $filesystem;
        $this->yaml = $yaml;
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
        $configurationFile = $this->getValidationCodeBucketConfigPath();

        if (!$this->filesystem->exists($configurationFile)) {
            $configurationFile = $this->getValidationConfigPath();
        }

        if (!$this->filesystem->exists($configurationFile)) {
            throw new CacheFileNotFoundException(static::EXCEPTION_MESSAGE_CACHE_FILE_NOT_FOUND);
        }

        $configuration = $this->yaml->parseFile($configurationFile);

        $resourceType = $restRequest->getResource()->getType();
        $requestMethod = strtolower($restRequest->getMetadata()->getMethod());

        if (empty($configuration[$resourceType][$requestMethod])) {
            return [];
        }

        return $configuration[$resourceType][$requestMethod];
    }

    /**
     * @deprecated Use {@link getValidationCodeBucketConfigPath()} instead.
     *
     * @return string
     */
    protected function getValidationConfigPath(): string
    {
        return defined('APPLICATION_STORE')
            ? sprintf($this->config->getValidationCacheFilenamePattern(), APPLICATION_STORE)
            : '';
    }

    /**
     * @return string
     */
    protected function getValidationCodeBucketConfigPath(): string
    {
        return sprintf($this->config->getValidationCodeBucketCacheFilenamePattern(), APPLICATION_CODE_BUCKET);
    }
}
