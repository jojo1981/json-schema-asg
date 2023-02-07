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

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class MixedBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return JsonKeys::getMixedKeys();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @return void
     */
    protected function buildNode(string $key, mixed $value, Context $context): void
    {
        if (JsonKeys::KEY_CONST === $key) {
            $context->getParentSchemaNode()->setConst($value);
        }
        if (JsonKeys::KEY_DEFAULT === $key) {
            $context->getParentSchemaNode()->setDefault($value);
        }
    }
}
