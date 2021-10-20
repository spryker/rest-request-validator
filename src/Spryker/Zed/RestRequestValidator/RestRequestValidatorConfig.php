<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator;

use Spryker\Shared\RestRequestValidator\RestRequestValidatorConfig as RestRequestValidatorConfigShared;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class RestRequestValidatorConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const VALIDATION_FILENAME_PATTERN = '*.validation.yaml';

    /**
     * @var string
     */
    protected const PATH_PATTERN_PROJECT_STORE_VALIDATION = '/*/Glue/*%s/Validation';

    /**
     * @var string
     */
    protected const PATH_PATTERN_PROJECT_VALIDATION = '/*/Glue/*/Validation';

    /**
     * @var string
     */
    protected const PATH_PATTERN_STORE_MODULES = '/(%s)\/Validation/';

    /**
     * @var string
     */
    protected const PATH_PATTERN_CORE_VALIDATION = '/*/*/*/*/Glue/*/Validation';

    /**
     * @api
     *
     * @deprecated Use getValidationSchemaPathPatterns instead.
     *
     * @return array<string>
     */
    public function getValidationSchemaPathPattern(): array
    {
        return [
            $this->getCorePathPattern(),
            $this->getProjectPathPattern(),
            $this->getStorePathPattern(),
        ];
    }

    /**
     * @api
     *
     * @return string
     */
    public function getValidationSchemaFileNamePattern(): string
    {
        return static::VALIDATION_FILENAME_PATTERN;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getStorePathPattern(): string
    {
        return APPLICATION_SOURCE_DIR . static::PATH_PATTERN_PROJECT_STORE_VALIDATION;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getProjectPathPattern(): string
    {
        return APPLICATION_SOURCE_DIR . static::PATH_PATTERN_PROJECT_VALIDATION;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getCorePathPattern(): string
    {
        return APPLICATION_VENDOR_DIR . static::PATH_PATTERN_CORE_VALIDATION;
    }

    /**
     * @api
     *
     * @deprecated Use {@link getCodeBucketCacheFilePathPattern()} instead.
     *
     * @return string
     */
    public function getCacheFilePathPattern(): string
    {
        return APPLICATION_SOURCE_DIR . RestRequestValidatorConfigShared::VALIDATION_CACHE_FILENAME_PATTERN;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getCodeBucketCacheFilePathPattern(): string
    {
        return APPLICATION_SOURCE_DIR . RestRequestValidatorConfigShared::CODE_BUCKET_VALIDATION_CACHE_FILENAME_PATTERN;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getStoreModulesPattern(): string
    {
        return static::PATH_PATTERN_STORE_MODULES;
    }
}
