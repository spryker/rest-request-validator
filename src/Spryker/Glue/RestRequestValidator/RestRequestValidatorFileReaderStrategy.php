<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\RestRequestValidator;

use Spryker\Glue\RestRequestValidator\Processor\Validator\Configuration\Reader\RestRequestValidatorConfigFileReaderInterface;

class RestRequestValidatorFileReaderStrategy
{
    /**
     * @var \Spryker\Glue\RestRequestValidator\Processor\Validator\Configuration\Reader\RestRequestValidatorConfigFileReaderInterface[]
     */
    protected $fileReaders;

    /**
     * @var \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig
     */
    protected $config;

    /**
     * @param \Spryker\Glue\RestRequestValidator\Processor\Validator\Configuration\Reader\RestRequestValidatorConfigFileReaderInterface[] $fileReaders
     * @param \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig $config
     */
    public function __construct(
        RestRequestValidatorConfigFileReaderInterface $fileReaders,
        RestRequestValidatorConfig $config
    ) {
        $this->fileReaders = $fileReaders;
        $this->config = $config;
    }

    public function getFileReader()
    {
        return $this->fileReaders[$this->config->getValidationCodeBucketCacheFileType()];
    }
}
