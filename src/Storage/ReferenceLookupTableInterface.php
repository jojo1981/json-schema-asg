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

namespace Jojo1981\JsonSchemaAsg\Storage;

use InvalidArgumentException;
use Jojo1981\JsonSchemaAsg\Value\Reference;
use LogicException;

/**
 * @package Jojo1981\JsonSchemaAsg\Storage
 */
interface ReferenceLookupTableInterface
{
    /**
     * Peek at the last item on the stack. Return null if the stack is empty
     *
     * @return null|Reference
     */
    public function peek(): ?Reference;

    /**
     * Push a reference on the stack. The reference must have an uri with an absolute path in it.
     * Throws an invalid argument exception when the reference is not valid.
     *
     * @param Reference $reference
     * @throws InvalidArgumentException
     * @return void
     */
    public function push(Reference $reference): void;

    /**
     * Pop the last reference from the stack. Throws a logic exception when the stack is empty.
     *
     * @throws LogicException
     * @return Reference
     */
    public function pop(): Reference;

    /**
     * Check if the stack is empty
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Check if the stack has references
     *
     * @return bool
     */
    public function isNonEmpty(): bool;

    /**
     * Clear the stack at once
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Get number of reference on the stack
     *
     * @return int
     */
    public function getSize(): int;

    /**
     * Checks if the passed reference fits in one of the references on the stack.
     * When it fits in from the start then it's a circular reference.
     * The reference must have an uri with an absolute path in it.
     * Throws an invalid argument exception when the reference is not valid.
     *
     * @param Reference $reference
     * @throws InvalidArgumentException
     * @return bool
     */
    public function isCircularReference(Reference $reference): bool;
}
