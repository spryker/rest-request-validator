<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Dependency\External;

use Symfony\Component\Filesystem\Filesystem;

class RestRequestValidatorToFilesystemAdapter implements RestRequestValidatorToFilesystemAdapterInterface
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    public function dumpFile(string $filename, string $content): void
    {
        $this->filesystem->dumpFile($filename, $content);
    }

    public function remove(array $files): void
    {
        $this->filesystem->remove($files);
    }
}
