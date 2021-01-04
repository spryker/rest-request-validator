<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Business;

use Spryker\Zed\RestRequestValidator\Business\Translator\RestRequestValidatorTranslatorInterface;
use Spryker\Zed\RestRequestValidator\RestRequestValidatorConfig;

class RestRequestValidatorTranslatorStrategy
{
    /**
     * @var \Spryker\Zed\RestRequestValidator\Business\Translator\RestRequestValidatorTranslatorInterface[]
     */
    protected $translators;

    /**
     * @var \Spryker\Zed\RestRequestValidator\RestRequestValidatorConfig
     */
    protected $config;

    /**
     * @param \Spryker\Zed\RestRequestValidator\Business\Translator\RestRequestValidatorTranslatorInterface[] $translators
     * @param \Spryker\Zed\RestRequestValidator\RestRequestValidatorConfig $config
     */
    public function __construct(array $translators, RestRequestValidatorConfig $config)
    {
        $this->translators = $translators;
        $this->config = $config;
    }

    /**
     * @return \Spryker\Zed\RestRequestValidator\Business\Translator\RestRequestValidatorTranslatorInterface
     */
    public function getTranslator(): RestRequestValidatorTranslatorInterface
    {
        return $this->translators[$this->config->getValidationCodeBucketCacheFileType()];
    }
}
