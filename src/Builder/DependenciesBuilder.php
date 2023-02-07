<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
declare(strict_types=1);

namespace Jojo1981\JsonSchemaAsg\Builder;

use Jojo1981\JsonSchemaAsg\Asg\DependenciesNode;
use Jojo1981\JsonSchemaAsg\Asg\DependencyNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;
use LogicException;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class DependenciesBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return [JsonKeys::KEY_DEPENDENCIES];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @return void
     * @throws LogicException
     */
    protected function buildNode(string $key, mixed $value, Context $context): void
    {
        if (!empty($value) && !ArrayHelper::isAssociativeArray($value)) {
            throw new LogicException('Expected ' . JsonKeys::KEY_DEPENDENCIES . ' to have an object as value');
        }

        $dependencyNodes = [];
        foreach ($value as $propertyName => $schemaData) {
            $this->assertIsSequenceOfStringValuesOrAssociativeArray($propertyName, $schemaData);
            $schemaNode = null;
            $sequenceOfString = null;
            if (ArrayHelper::isSequenceArray($schemaData)) {
                $sequenceOfString = $schemaData;
            } else {
                $schemaNode = $context->resolveSchemaDataRecursively($schemaData, $context->getParentReference());
            }
            $dependencyNodes[] = new DependencyNode($propertyName, $sequenceOfString, $schemaNode);
        }
        $context->getParentSchemaNode()->setDependencies(new DependenciesNode($dependencyNodes));
    }

    /**
     * @param string $propertyName
     * @param mixed $value
     * @return void
     * @throws LogicException
     */
    private function assertIsSequenceOfStringValuesOrAssociativeArray(string $propertyName, mixed $value): void
    {
        if (!ArrayHelper::isSequenceArray($value) && !ArrayHelper::isAssociativeArray($value)) {
            throw new LogicException('Expected ' . JsonKeys::KEY_DEPENDENCIES . ' for property: ' . $propertyName . 'to have an schema object or a sequence of strings as value');
        }

        if (ArrayHelper::isSequenceArray($value) && !ArrayHelper::areAllArrayElementsOfType($value, 'string')) {
            throw new LogicException('Expected ' . JsonKeys::KEY_DEPENDENCIES . ' for property: ' . $propertyName . 'to have an object or sequence of strings as value');
        }
    }
}
