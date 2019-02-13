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
        $this->assertIsSequenceOfStringValuesOrAssociativeArray($value);

        $dependenciesNode = new DependenciesNode($context->getParentSchemaNode());
        if (ArrayHelper::isSequenceArray($value)) {
            $dependenciesNode->setSequenceOfString($value);
        } else {
            $schemaNode = $context->resolveSchemaDataRecursively($value, $context->getParentReference());
            $dependenciesNode->setSchema($schemaNode);
        }
        $context->getParentSchemaNode()->setDependencies($dependenciesNode);
    }

    /**
     * @param array $value
     * @throws \LogicException
     * @return void
     */
    private function assertIsSequenceOfStringValuesOrAssociativeArray($value): void
    {
        if (!ArrayHelper::isSequenceArray($value) && !ArrayHelper::isAssociativeArray($value)) {
            throw new \LogicException('Expected ' . JsonKeys::KEY_DEPENDENCIES . ' to have an schema object or a sequence of strings as value');
        }

        if (ArrayHelper::isSequenceArray($value) && !ArrayHelper::areAllArrayElementsOfType($value, 'string')) {
            throw new \LogicException('Expected ' . JsonKeys::KEY_DEPENDENCIES . ' to have an object or sequence of strings as value');
        }
    }
}