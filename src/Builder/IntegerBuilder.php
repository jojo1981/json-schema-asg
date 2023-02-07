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
use function is_int;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class IntegerBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return JsonKeys::getIntegerKeys();
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
        if (!is_int($value) || $value < 0) {
            throw new LogicException('Expected a non negative integer');
        }

        switch ($key) {
            case JsonKeys::KEY_MAX_LENGTH:
                $context->getParentSchemaNode()->setMaxLength($value);
                break;
            case JsonKeys::KEY_MIN_LENGTH:
                $context->getParentSchemaNode()->setMinLength($value);
                break;
            case JsonKeys::KEY_MAX_ITEMS:
                $context->getParentSchemaNode()->setMaxItems($value);
                break;
            case JsonKeys::KEY_MIN_ITEMS:
                $context->getParentSchemaNode()->setMinItems($value);
                break;
            case JsonKeys::KEY_MAX_PROPERTIES:
                $context->getParentSchemaNode()->setMaxProperties($value);
                break;
            case JsonKeys::KEY_MIN_PROPERTIES:
                $context->getParentSchemaNode()->setMinProperties($value);
                break;
        }
    }
}
