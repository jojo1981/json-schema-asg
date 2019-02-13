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

use Jojo1981\JsonSchemaAsg\Asg\SequenceOfSchemaNodesNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class SequenceOfSchemasBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return JsonKeys::getSequenceOfSchemasKeys();
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
        if (!ArrayHelper::isSequenceArray($value)) {
            throw new \LogicException('Expected value to be a sequence of schemas');
        }

        $sequenceOfSchemaNodesNode = new SequenceOfSchemaNodesNode($context->getParentSchemaNode());
        foreach ($value as $schemaData) {
            $schemaNode = $context->resolveSchemaDataRecursively($schemaData, $context->getParentReference());
            $sequenceOfSchemaNodesNode->addSchemaNode($schemaNode);
        }

        switch ($key) {
            case JsonKeys::KEY_ALL_OF:
                $context->getParentSchemaNode()->setAllOf($sequenceOfSchemaNodesNode);
                break;
            case JsonKeys::KEY_ANY_OF:
                $context->getParentSchemaNode()->setAnyOf($sequenceOfSchemaNodesNode);
                break;
            case JsonKeys::KEY_ONE_OF:
                $context->getParentSchemaNode()->setOneOf($sequenceOfSchemaNodesNode);
                break;
        }
    }
}