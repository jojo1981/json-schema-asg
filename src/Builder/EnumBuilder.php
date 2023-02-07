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

use Jojo1981\JsonSchemaAsg\Asg\EnumNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;
use LogicException;
use function array_map;
use function count;
use function is_array;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class EnumBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return [JsonKeys::KEY_ENUM];
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
        if (!is_array($value) || ArrayHelper::isAssociativeArray($value)) {
            throw new LogicException('Expected a sequence of any type with unique items');
        }
        if (!ArrayHelper::areAllArrayElementsOfType($value, 'string')) {
            throw new LogicException('Expected all values to be of type string');
        }
        $this->assertUniqueItems($value);

        $context->getParentSchemaNode()->setEnum(new EnumNode($value));
    }

    /**
     * @param array $value
     * @return void
     * @throws LogicException
     */
    private function assertUniqueItems(array $value): void
    {
        $items = array_map('serialize', $value);
        $length = count($items);
        for ($i = 0; $i < $length; $i++) {
            for ($k = $i + 1; $k < $length; $k++) {
                $item1 = $items[$i];
                $item2 = $items[$k];
                if ($item1 === $item2) {
                    throw new LogicException('Expect all items to be unique');
                }
            }
        }
    }
}
