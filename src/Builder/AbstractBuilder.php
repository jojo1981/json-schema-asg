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
 * This abstract builder class only validates if the builder is not unjustified being called.
 *
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
abstract class AbstractBuilder implements BuilderInterface
{
    /**
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @throws BuilderException
     * @return void
     */
    final public function build(string $key, $value, Context $context): void
    {
        if (!\in_array($key, $this->getAcceptedKeys(), true)) {
            throw BuilderException::unjustifiedCallingBuilder();
        }

        $this->buildNode($key, $value, $context);
    }

    /**
     * The build will be delegated to this method an should be implemented in the concrete builder classes
     *
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @throws BuilderException
     * @return void
     */
    abstract protected function buildNode(string $key, $value, Context $context): void;
}
