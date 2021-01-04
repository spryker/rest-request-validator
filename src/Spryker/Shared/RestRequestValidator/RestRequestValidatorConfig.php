<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\RestRequestValidator;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class RestRequestValidatorConfig extends AbstractBundleConfig
{
    public const VALIDATION_CACHE_TYPE = 'VALIDATION_CACHE_TYPE';

    public const VALIDATION_CACHE_TYPE_YML = 'yaml';
    public const VALIDATION_CACHE_TYPE_PHP = 'php';
    public const VALIDATION_CACHE_TYPE_DEFAULT = 'yaml';

    /**
     * @deprecated Use CODE_BUCKET_VALIDATION_CACHE_FILENAME_PATTERN instead.
     */
    public const VALIDATION_CACHE_FILENAME_PATTERN = '/Generated/Glue/Validator/%s/validation.cache';
    public const CODE_BUCKET_VALIDATION_CACHE_FILENAME_PATTERN = '/Generated/Glue/Validator/Validation%s';
}
