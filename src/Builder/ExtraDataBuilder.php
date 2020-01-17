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

use Jojo1981\JsonSchemaAsg\BuilderRegistry;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class ExtraDataBuilder implements BuilderInterface
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return [BuilderRegistry::WILDCARD_SYMBOL];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function acceptKey(string $key): bool
    {
        return true;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @return void
     */
    public function build(string $key, $value, Context $context): void
    {
        $context->getParentSchemaNode()->addExtraData($key, $value);
    }
}