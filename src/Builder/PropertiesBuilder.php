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

use Jojo1981\JsonSchemaAsg\Asg\PropertiesNode;
use Jojo1981\JsonSchemaAsg\Asg\PropertyNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Helper\ReferenceHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class PropertiesBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return [JsonKeys::KEY_PROPERTIES];
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
            throw new \LogicException('Expected properties to have an object as value');
        }

        $propertiesNode = new PropertiesNode($context->getParentSchemaNode());
        foreach ($value as $propertyName => $propertySchemaData) {
            $propertyNode = new PropertyNode($propertiesNode, $propertyName);
            $newReference = ReferenceHelper::createFromReferenceByAppendingKey($context->getParentReference(), $propertyName);
            $propertyObjectSchemaNode = $context->resolveSchemaDataRecursively($propertySchemaData, $newReference);
            $propertyNode->setSchema($propertyObjectSchemaNode);
            $propertiesNode->addPropertyNode($propertyNode);
        }
        $context->getParentSchemaNode()->setProperties($propertiesNode);
    }
}