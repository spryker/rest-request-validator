<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Spryker\Zed\RestRequestValidator\Business\RestRequestValidatorFacadeInterface getFacade()
 */
class RemoveRestApiValidationCacheConsole extends Console
{
    /**
     * @var string
     */
    protected const COMMAND_NAME = 'rest-api:remove-validation-cache';

    /**
     * @var string
     */
    protected const DESCRIPTION = 'Removes the cache for rest request validation rules.';

    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::DESCRIPTION);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getMessenger()->info(static::DESCRIPTION);
        $this->getFacade()->removeValidationCacheForCodeBucket(APPLICATION_CODE_BUCKET);

        return static::CODE_SUCCESS;
    }
}
