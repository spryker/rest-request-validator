<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Business\Saver;

interface RestRequestValidatorCacheSaverInterface
{
    public function save(array $validatorConfig, string $storeName): void;

    public function saveCacheForCodeBucket(array $validatorConfig, string $codeBucket): void;
}
