<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\RestRequestValidator\Business\Merger;

class RestRequestValidatorSchemaMerger implements RestRequestValidatorSchemaMergerInterface
{
    public function merge(array $validatorSchema): array
    {
        $validatorSchemaMerged = [];
        foreach ($validatorSchema as $resourceName => $validationConfigs) {
            if (count($validationConfigs) === 1) {
                $validatorSchemaMerged[$resourceName] = reset($validationConfigs);
            } else {
                $validatorSchemaMerged[$resourceName] = $this->mergeOverwrittenValidatorConfig($validationConfigs);
            }
        }

        return $validatorSchemaMerged;
    }

    protected function mergeOverwrittenValidatorConfig(array $validationConfigs): array
    {
        $resultingConfiguration = [];

        foreach ($validationConfigs as $validationSchemaScoped) {
            foreach ($validationSchemaScoped as $actionName => $fieldsConfig) {
                $resultingConfiguration = $this->mergeOverlappingConfig($actionName, $resultingConfiguration, $fieldsConfig);
            }
        }

        return $resultingConfiguration;
    }

    protected function mergeOverlappingConfig(string $actionName, array $resultingConfiguration, array $fieldsConfig): array
    {
        if (!array_key_exists($actionName, $resultingConfiguration)) {
            $resultingConfiguration[$actionName] = $fieldsConfig;

            return $resultingConfiguration;
        }

        foreach ($fieldsConfig as $fieldName => $validatorsList) {
            $resultingConfiguration[$actionName][$fieldName] = $validatorsList;
        }

        return $resultingConfiguration;
    }
}
