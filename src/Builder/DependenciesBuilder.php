<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\Builder;

use Jojo1981\JsonSchemaAsg\Asg\DependenciesNode;
use Jojo1981\JsonSchemaAsg\Asg\DependencyNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;

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
     * @throws \LogicException
     * @return void
     */
    protected function buildNode(string $key, $value, Context $context): void
    {
        if (!empty($value) && !ArrayHelper::isAssociativeArray($value)) {
            throw new \LogicException('Expected ' . JsonKeys::KEY_DEPENDENCIES . ' to have an object as value');
        }

        $dependenciesNode = new DependenciesNode($context->getParentSchemaNode());
        foreach ($value as $propertyName => $schemaData) {
            $this->assertIsSequenceOfStringValuesOrAssociativeArray($propertyName, $schemaData);
            $dependencyNode = new DependencyNode($dependenciesNode, $propertyName);
            if (ArrayHelper::isSequenceArray($schemaData)) {
                $dependencyNode->setSequenceOfString($schemaData);
            } else {
                $schemaNode = $context->resolveSchemaDataRecursively($schemaData, $context->getParentReference());
                $dependencyNode->setSchema($schemaNode);
            }
            $dependenciesNode->addDependencyNode($dependencyNode);
        }
        $context->getParentSchemaNode()->setDependencies($dependenciesNode);
    }

    /**
     * @param string $propertyName
     * @param mixed $value
     * @throws \LogicException
     * @return void
     */
    private function assertIsSequenceOfStringValuesOrAssociativeArray(string $propertyName, $value): void
    {
        if (!ArrayHelper::isSequenceArray($value) && !ArrayHelper::isAssociativeArray($value)) {
            throw new \LogicException('Expected ' . JsonKeys::KEY_DEPENDENCIES . ' for property: ' . $propertyName . 'to have an schema object or a sequence of strings as value');
        }

        if (ArrayHelper::isSequenceArray($value) && !ArrayHelper::areAllArrayElementsOfType($value, 'string')) {
            throw new \LogicException('Expected ' . JsonKeys::KEY_DEPENDENCIES . ' for property: ' . $propertyName . 'to have an object or sequence of strings as value');
        }
    }
}