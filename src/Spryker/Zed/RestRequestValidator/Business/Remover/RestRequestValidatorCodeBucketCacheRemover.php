<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Business\Remover;

use Spryker\Zed\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface;
use Spryker\Zed\RestRequestValidator\RestRequestValidatorConfig;

class RestRequestValidatorCodeBucketCacheRemover implements RestRequestValidatorCodeBucketCacheRemoverInterface
{
    /**
     * @var \Spryker\Zed\RestRequestValidator\Dependency\External\RestRequestValidatorToFilesystemAdapterInterface
     */
    protected $filesystem;

    /**
     * @var \Spryker\Zed\RestRequestValidator\RestRequestValidatorConfig
     */
    protected $config;

    public function __construct(
        RestRequestValidatorToFilesystemAdapterInterface $filesystem,
        RestRequestValidatorConfig $config
    ) {
        $this->filesystem = $filesystem;
        $this->config = $config;
    }

    public function remove(string $codeBucket): void
    {
        $outdatedConfigFiles = $this->getOutdatedConfig($codeBucket);
        if ($outdatedConfigFiles) {
            $this->filesystem->remove($outdatedConfigFiles);
        }
    }

    /**
     * @param string $codeBucket
     *
     * @return array<string>
     */
    protected function getOutdatedConfig(string $codeBucket): array
    {
        return glob(sprintf($this->config->getCodeBucketCacheFilePathPattern(), $codeBucket), GLOB_NOSORT) ?: [];
    }
}
