<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\RestRequestValidator;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class RestRequestValidatorConfig extends AbstractBundleConfig
{
    /**
     * @deprecated Use CODE_BUCKET_VALIDATION_CACHE_FILENAME_PATTERN instead.
     *
     * @var string
     */
    public const VALIDATION_CACHE_FILENAME_PATTERN = '/Generated/Glue/Validator/%s/validation.cache';

    /**
     * @var string
     */
    public const CODE_BUCKET_VALIDATION_CACHE_FILENAME_PATTERN = '/Generated/Glue/Validator/validation%s.cache';
}
