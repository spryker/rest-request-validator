<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Dependency\External;

interface RestRequestValidatorToYamlAdapterInterface
{
    /**
     * @param int-mask-of<\Symfony\Component\Yaml\Yaml::DUMP_*> $flags
     */
    // phpcs:ignore Spryker.Commenting.DocBlockParamAllowDefaultValue.Typehint
    public function dump(array $input, int $inline = 2, int $indent = 4, int $flags = 0): string;

    /**
     * @param int-mask-of<\Symfony\Component\Yaml\Yaml::PARSE_*> $flags
     */
    // phpcs:ignore Spryker.Commenting.DocBlockParamAllowDefaultValue.Typehint
    public function parseFile(string $filename, int $flags = 0): array;
}
