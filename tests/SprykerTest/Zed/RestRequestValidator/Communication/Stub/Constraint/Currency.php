<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\RestRequestValidator\Communication\Stub\Constraint;

use Symfony\Component\Validator\Constraint as SymfonyConstraint;

class Currency extends SymfonyConstraint
{
    /**
     * @var array<string>
     */
    protected const VALID_CURRENCIES = [
        'FJD',
    ];

    public function getTargets(): string
    {
        return static::CLASS_CONSTRAINT;
    }

    public function isValidCurrencyIsoCode(string $isoCode): bool
    {
        return in_array($isoCode, static::VALID_CURRENCIES);
    }
}
