<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Business\Translator;

use Spryker\Zed\RestRequestValidator\RestRequestValidatorConfig;

class RestRequestValidatorPhpTranslator implements RestRequestValidatorTranslatorInterface
{
    /**
     * @var \Spryker\Zed\RestRequestValidator\RestRequestValidatorConfig
     */
    protected $config;

    /**
     * @var string
     */
    protected $codeBucket;

    /**
     * @param \Spryker\Zed\RestRequestValidator\RestRequestValidatorConfig $config
     */
    public function __construct(RestRequestValidatorConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $codeBucket
     *
     * @return void
     */
    public function setCodeBucket(string $codeBucket): void
    {
        $this->codeBucket = $codeBucket;
    }

    /**
     * @param array $source
     * @param string $pathPattern
     *
     * @return string
     */
    public function translate(array $source, ?string $codeBucket = null): string
    {
        $text = $this->getPreparedTemplate($source, $codeBucket);
        return $text;
    }

    /**
     * @param array $source
     *
     * @return string
     */
    protected function getPreparedTemplate(array $source, string $codeBucket): string
    {
        $fullyQualifiedClassname = str_replace(
            '/',
            '\\',
            trim($this->getCodeBucketCacheFilePattern($codeBucket), '/')
        );

        $explodedClassname = explode('\\', $fullyQualifiedClassname);
        $className = array_pop($explodedClassname);
        $namespace = implode('\\', $explodedClassname);

        return sprintf(
            <<<EOP
            <?php

            namespace %s;

            use Spryker\Shared\RestRequestValidator\ValidationCacheInterface;

            class %s implements ValidationCacheInterface
            {
                public function getConfigCache(): array
                {
                    return %s;
                }
            }
            EOP,
            $namespace,
            $className,
            var_export($source, true)
        );
    }

    /**
     * @return string
     */
    protected function getCodeBucketCacheFilePattern(string $codeBucket): string
    {
        return sprintf($this->config->getValidationCodeBucketCachePathPattern(), $codeBucket);
    }
}
