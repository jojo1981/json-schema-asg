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
use function is_float;
use function is_int;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class NumberBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return JsonKeys::getNumberKeys();
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
        if (!is_int($value) && !is_float($value)) {
            throw new LogicException('Expected type to be of type number');
        }

        if (JsonKeys::KEY_MULTIPLE_OF === $key && $value < 1) {
            throw new LogicException('Expected to have a number value which is higher than zero');
        }

        switch ($key) {
            case JsonKeys::KEY_MULTIPLE_OF:
                $context->getParentSchemaNode()->setMultipleOf((float) $value);
                break;
            case JsonKeys::KEY_MAXIMUM:
                $context->getParentSchemaNode()->setMaximum((float) $value);
                break;
            case JsonKeys::KEY_EXCLUSIVE_MAXIMUM:
                $context->getParentSchemaNode()->setExclusiveMaximum((float) $value);
                break;
            case JsonKeys::KEY_MINIMUM:
                $context->getParentSchemaNode()->setMinimum((float) $value);
                break;
            case JsonKeys::KEY_EXCLUSIVE_MINIMUM:
                $context->getParentSchemaNode()->setExclusiveMinimum((float) $value);
                break;
        }
    }
}
