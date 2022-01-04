<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\RestRequestValidator;

use Spryker\Glue\Kernel\AbstractBundleConfig;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\RestRequestValidator\RestRequestValidatorConfig as RestRequestValidatorConfigShared;
use Symfony\Component\HttpFoundation\Request;

class RestRequestValidatorConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESPONSE_CODE_REQUEST_INVALID = '901';

    /**
     * @var string
     */
    protected const CONSTRAINTS_NAMESPACE_SYMFONY_COMPONENT_VALIDATOR = 'Symfony\\Component\\Validator\\Constraints\\';

    /**
     * @var string
     */
    protected const CONSTRAINTS_NAMESPACE_PROJECT_STORE_REST_REQUEST_VALIDATOR = '\\Glue\\RestRequestValidator%s\\Constraints\\';

    /**
     * @var string
     */
    protected const CONSTRAINTS_NAMESPACE_REST_REQUEST_VALIDATOR = '\\Glue\\RestRequestValidator\\Constraints\\';

    /**
     * @api
     *
     * @return array<string>
     */
    public function getAvailableConstraintNamespaces(): array
    {
        return array_merge($this->getProjectNamespaces(), $this->getCoreNamespaces());
    }

    /**
     * @api
     *
     * @return array<string>
     */
    public function getHttpMethodsThatRequireValidation(): array
    {
        return [
            Request::METHOD_POST,
            Request::METHOD_PATCH,
        ];
    }

    /**
     * @api
     *
     * @deprecated Use getValidationCodeBucketCacheFilenamePattern instead.
     *
     * @return string
     */
    public function getValidationCacheFilenamePattern(): string
    {
        return APPLICATION_SOURCE_DIR . RestRequestValidatorConfigShared::VALIDATION_CACHE_FILENAME_PATTERN;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getValidationCodeBucketCacheFilenamePattern(): string
    {
        return APPLICATION_SOURCE_DIR . RestRequestValidatorConfigShared::CODE_BUCKET_VALIDATION_CACHE_FILENAME_PATTERN;
    }

    /**
     * @api
     *
     * @return array<string, mixed>
     */
    public function getConstraintCollectionOptions(): array
    {
        return [
            'allowExtraFields' => true,
            'groups' => ['Default'],
        ];
    }

    /**
     * @return array<string>
     */
    private function getCoreNamespaces(): array
    {
        $coreConstraintNamespaces = [];

        foreach ($this->get(KernelConstants::CORE_NAMESPACES) as $coreNamespace) {
            $coreConstraintNamespaces[] = $coreNamespace . static::CONSTRAINTS_NAMESPACE_REST_REQUEST_VALIDATOR;
        }
        $coreConstraintNamespaces[] = static::CONSTRAINTS_NAMESPACE_SYMFONY_COMPONENT_VALIDATOR;

        return $coreConstraintNamespaces;
    }

    /**
     * @return array<string>
     */
    private function getProjectNamespaces(): array
    {
        $projectConstraintNamespaces = [];

        foreach ($this->get(KernelConstants::PROJECT_NAMESPACES) as $projectNamespaces) {
            $projectConstraintNamespaces[] = $projectNamespaces .
                sprintf(static::CONSTRAINTS_NAMESPACE_PROJECT_STORE_REST_REQUEST_VALIDATOR, APPLICATION_CODE_BUCKET);
            $projectConstraintNamespaces[] = $projectNamespaces . static::CONSTRAINTS_NAMESPACE_REST_REQUEST_VALIDATOR;
        }

        return $projectConstraintNamespaces;
    }
}
