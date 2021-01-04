<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\RestRequestValidator\Processor\Validator\Configuration\Reader;

use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface;
use Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface;
use Spryker\Glue\RestRequestValidator\Processor\Exception\CacheFileNotFoundException;
use Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig;

class RestRequestValidatorConfigYamlReader implements RestRequestValidatorConfigFileReaderInterface
{
    /**
     * @var \Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface
     */
    protected $filesystem;

    /**
     * @var \Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface
     */
    protected $yamlAdapter;

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @param \Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface $filesystem
     * @param \Spryker\Glue\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface $yamlAdapter
     * @param \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig $config
     */
    public function __construct(
        RestRequestValidatorToFilesystemAdapterInterface $filesystem,
        RestRequestValidatorToYamlAdapterInterface $yamlAdapter,
        RestRequestValidatorConfig $config
    ) {
        $this->filesystem = $filesystem;
        $this->yamlAdapter = $yamlAdapter;
        $this->config = $config;
    }

    public function readConfig(): array
    {
        $configurationFile = $this->getValidationCodeBucketConfigPath();

        if (!$this->filesystem->exists($configurationFile)) {
            $configurationFile = $this->getValidationConfigPath();
        }

        if (!$this->filesystem->exists($configurationFile)) {
            throw new CacheFileNotFoundException(static::EXCEPTION_MESSAGE_CACHE_FILE_NOT_FOUND);
        }

        return $this->yamlAdapter->parseFile($configurationFile);
    }

    /**
     * @deprecated Use {@link getValidationCodeBucketConfigPath()} instead.
     *
     * @return string
     */
    protected function getValidationConfigPath(): string
    {
        return sprintf($this->config->getValidationCacheFilenamePattern(), APPLICATION_STORE);
    }

    /**
     * @return string
     */
    protected function getValidationCodeBucketConfigPath(): string
    {
        return sprintf($this->config->getValidationCodeBucketCacheFilenamePattern(), APPLICATION_CODE_BUCKET);
    }
}
