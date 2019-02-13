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

use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class DirectSchemaBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return JsonKeys::getSingleSchemaKeys();
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
        if (!\is_bool($value) && !ArrayHelper::isAssociativeArray($value)) {
            throw new \LogicException('Expected value to be of type boolean or object');
        }

        $schemaNode = $context->resolveSchemaDataRecursively($value, $context->getParentReference());
        switch ($key) {
            case JsonKeys::KEY_ADDITIONAL_ITEMS:
                $context->getParentSchemaNode()->setAdditionalItems($schemaNode);
                break;
            case JsonKeys::KEY_CONTAINS:
                $context->getParentSchemaNode()->setContains($schemaNode);
                break;
            case JsonKeys::KEY_ADDITIONAL_PROPERTIES:
                $context->getParentSchemaNode()->setAdditionalProperties($schemaNode);
                break;
            case JsonKeys::KEY_PROPERTY_NAMES:
                $context->getParentSchemaNode()->setPropertyNames($schemaNode);
                break;
            case JsonKeys::KEY_IF:
                $context->getParentSchemaNode()->setIf($schemaNode);
                break;
            case JsonKeys::KEY_THEN:
                $context->getParentSchemaNode()->setThen($schemaNode);
                break;
            case JsonKeys::KEY_ELSE:
                $context->getParentSchemaNode()->setElse($schemaNode);
                break;
            case JsonKeys::KEY_NOT:
                $context->getParentSchemaNode()->setNot($schemaNode);
                break;
        }
    }
}