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

use Jojo1981\JsonSchemaAsg\Asg\PatternPropertiesNode;
use Jojo1981\JsonSchemaAsg\Asg\PatternPropertyNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Helper\ReferenceHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class PatternPropertiesBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return [JsonKeys::KEY_PATTERN_PROPERTIES];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @throws \LogicException
     * @throws \UnexpectedValueException
     * @return void
     */
    protected function buildNode(string $key, $value, Context $context): void
    {
        if (!empty($value) && !ArrayHelper::isAssociativeArray($value)) {
            throw new \LogicException('Expected pattern properties to have an object as value');
        }

        $patternPropertiesNode = new PatternPropertiesNode($context->getParentSchemaNode());
        foreach ($value as $propertyPattern => $propertySchemaData) {
            $patternPropertyNode = new PatternPropertyNode($patternPropertiesNode, $propertyPattern);
            $newReference = ReferenceHelper::createFromReferenceByAppendingKey($context->getParentReference(), $propertyPattern);
            $propertyObjectSchemaNode = $context->resolveSchemaDataRecursively($propertySchemaData, $newReference);
            $patternPropertyNode->setSchema($propertyObjectSchemaNode);
            $patternPropertiesNode->addPatternPropertyNode($patternPropertyNode);
        }
        $context->getParentSchemaNode()->setPatternProperties($patternPropertiesNode);
    }
}