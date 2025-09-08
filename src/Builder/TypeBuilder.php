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

use InvalidArgumentException;
use Jojo1981\JsonSchemaAsg\Asg\SimpleTypeNode;
use Jojo1981\JsonSchemaAsg\Asg\SimpleTypesSequenceNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;
use LogicException;
use function array_map;
use function is_array;
use function is_string;

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
     * @return void
     * @throws LogicException
     */
    protected function buildNode(string $key, mixed $value, Context $context): void
    {
        if (is_string($value)) {
            $value = [$value];
        }

        if (is_array($value) && !empty($value) && !ArrayHelper::isAssociativeArray($value)) {
            $context->getParentSchemaNode()->setType($this->visitSimpleTypeOrSequenceOfSimpleTypes($value));
        } else {
            throw new LogicException('Expected value of `' . JsonKeys::KEY_TYPE . '` to be a string or a sequence of string');
        }
    }

    /**
     * @param string[] $values
     * @return SimpleTypesSequenceNode
     * @throws InvalidArgumentException
     */
    private function visitSimpleTypeOrSequenceOfSimpleTypes(array $values): SimpleTypesSequenceNode
    {
        return new SimpleTypesSequenceNode(array_map(fn (string $value): SimpleTypeNode => new SimpleTypeNode($value), $values));
    }
}
