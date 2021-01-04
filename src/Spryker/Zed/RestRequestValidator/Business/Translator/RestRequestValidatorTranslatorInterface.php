<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Business\Translator;

interface RestRequestValidatorTranslatorInterface
{
    /**
     * @param array $source
     * @param string $pathPattern
     *
     * @return string
     */
    public function translate(array $source, ?string $codeBucket = null): string;
}
