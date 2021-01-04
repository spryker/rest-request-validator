<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Business\Translator;

use Spryker\Zed\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface;

class RestRequestValidatorYamlTranslator implements RestRequestValidatorTranslatorInterface
{
    /**
     * @var \Spryker\Zed\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface
     */
    protected $yamlAdapter;

    /**
     * @var string
     */
    protected $codeBucket;

    /**
     * @param \Spryker\Zed\RestRequestValidator\Dependency\External\RestRequestValidatorToYamlAdapterInterface $yamlAdapter
     */
    public function __construct(RestRequestValidatorToYamlAdapterInterface $yamlAdapter)
    {
        $this->yamlAdapter = $yamlAdapter;
    }

    /**
     * @param array $source
     *
     * @return string
     */
    public function translate(array $source, ?string $codeBucket = null): string
    {
        return $this->yamlAdapter->dump($source);
    }
}
