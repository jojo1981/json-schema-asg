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

use Jojo1981\JsonSchemaAsg\Value\JsonKeys;
use LogicException;
use function is_bool;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class BooleanBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return JsonKeys::getBooleanKeys();
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
        if (!is_bool($value)) {
            throw new LogicException('Expected a boolean value instead of an object');
        }
        if (JsonKeys::KEY_READ_ONLY === $key) {
            $context->getParentSchemaNode()->setReadOnly($value);
        }
        if (JsonKeys::KEY_UNIQUE_ITEMS === $key) {
            $context->getParentSchemaNode()->setUniqueItems($value);
        }
    }
}
