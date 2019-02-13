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

use Jojo1981\JsonSchemaAsg\Asg\ObjectSchemaNode;
use Jojo1981\JsonSchemaAsg\Asg\SimpleTypeNode;
use Jojo1981\JsonSchemaAsg\Asg\SimpleTypesSequenceNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class TypeBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return [JsonKeys::KEY_TYPE];
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
        if (\is_string($value)) {
            $value = [$value];
        }

        if (\is_array($value) && !empty($value) && !ArrayHelper::isAssociativeArray($value)) {
            $context->getParentSchemaNode()->setType(
                $this->visitSimpleTypeOrSequenceOfSimpleTypes($value, $context->getParentSchemaNode())
            );
        } else {
            throw new \LogicException('Expected value of `' . JsonKeys::KEY_TYPE . '` to be a string or a sequence of string');
        }
    }

    /**
     * @param string[] $values
     * @param ObjectSchemaNode $parentSchemaNode
     * @return SimpleTypesSequenceNode
     */
    private function visitSimpleTypeOrSequenceOfSimpleTypes(
        array $values,
        ObjectSchemaNode $parentSchemaNode
    ): SimpleTypesSequenceNode
    {
        $simpleTypesSequenceNode = new SimpleTypesSequenceNode($parentSchemaNode);
        $simpleTypesSequenceNode->setSimpleTypeNodes(\array_map(
            function (string $value) use ($simpleTypesSequenceNode): SimpleTypeNode {
                return $this->visitSimpleType($simpleTypesSequenceNode, $value);
            },
            $values
        ));

        return $simpleTypesSequenceNode;
    }

    /**
     * @param SimpleTypesSequenceNode $parent
     * @param string $value
     * @throws \InvalidArgumentException
     * @return SimpleTypeNode
     */
    private function visitSimpleType(SimpleTypesSequenceNode $parent, string $value): SimpleTypeNode
    {
        return new SimpleTypeNode($parent, $value);
    }
}