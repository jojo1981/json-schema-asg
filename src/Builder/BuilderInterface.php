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

use Jojo1981\JsonSchemaAsg\Builder\Exception\BuilderException;

/**
 * This interface describes the interface for all builder classes. Builder classes are responsible for building
 * the correct ast node and attach it to the right parent. A builder claims a key or multiple keys for which he can
 * be build the correct ast node(s).
 *
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
interface BuilderInterface
{
    /**
     * Return the key(s) for which the builder can build ASG node(s)
     *
     * @return string[]
     */
    public function getAcceptedKeys(): array;

    /**
     * This method will be called when the builder has accepted the key and should validate and build the correct
     * node and attach it to the $parentSchemaNode
     *
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @throws BuilderException
     * @return void
     */
    public function build(string $key, $value, Context $context): void;
}