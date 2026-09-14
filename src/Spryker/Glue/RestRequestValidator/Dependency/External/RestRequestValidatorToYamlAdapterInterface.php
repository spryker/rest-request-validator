<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\RestRequestValidator\Dependency\External;

interface RestRequestValidatorToYamlAdapterInterface
{
    /**
     * @param int-mask-of<\Symfony\Component\Yaml\Yaml::PARSE_*> $flags
     */
    // phpcs:ignore Spryker.Commenting.DocBlockParamAllowDefaultValue.Typehint
    public function parseFile(string $filename, int $flags = 0): array;
}
