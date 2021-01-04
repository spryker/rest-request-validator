<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\RestRequestValidator\Processor\Validator\Configuration\Reader;

use Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig;
use Spryker\Shared\RestRequestValidator\ValidationCacheInterface;

class RestRequestValidatorConfigPhpReader implements RestRequestValidatorConfigFileReaderInterface
{
    /**
     * @var \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig
     */
    protected $config;

    /**
     * @param \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig $config
     */
    public function __construct(RestRequestValidatorConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function readConfig(): array
    {
        return $this->getCacheInstance()->getConfigCache();
    }

    /**
     * @return \Spryker\Shared\RestRequestValidator\ValidationCacheInterface
     */
    protected function getCacheInstance(): ValidationCacheInterface
    {
        $pattern = $this->getValidationCodeBucketCachePathPattern();
        $classname = $this->getClassnameByPattern($pattern);
        return new $classname;
    }

    /**
     * @return string
     */
    protected function getValidationCodeBucketCachePathPattern(): string
    {
        return sprintf($this->config->getValidationCodeBucketCachePathPattern(), APPLICATION_CODE_BUCKET);
    }

    /**
     * @param string $pattern
     *
     * @return string
     */
    protected function getClassnameByPattern(string $pattern): string
    {
        return str_replace('/','\\', $pattern);
    }
}
