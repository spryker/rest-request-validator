<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Dependency\External;

interface RestRequestValidatorToFilesystemAdapterInterface
{
    public function dumpFile(string $filename, string $content): void;

    public function remove(array $files): void;
}
