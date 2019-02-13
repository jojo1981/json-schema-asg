<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\Storage;

use Jojo1981\JsonSchemaAsg\Helper\ReferenceHelper;
use Jojo1981\JsonSchemaAsg\Value\Reference;

/**
 * This class is responsible for holding a stack with reference and can be used to check if a reference is a circular
 * reference. This will be used to prevent an infinite loop and create an ASG Reference node which will be linked to the
 * schema node and has the is circular reference set to `true`.
 *
 * @package Jojo1981\JsonSchemaAsg\Storage
 */
class ReferenceLookupTable implements ReferenceLookupTableInterface
{
    /** @var Reference[] */
    private $stack = [];

    /**
     * @return Reference|null
     */
    public function peek(): ?Reference
    {
        return \count($this->stack) ? \end($this->stack) : null;
    }

    /**
     * @param Reference $reference
     * @throws \InvalidArgumentException
     * @return void
     */
    public function push(Reference $reference): void
    {
        ReferenceHelper::assertReferenceNotLocalAndNotRelative($reference);

        $this->stack[] = $reference;
    }

    /**
     * @throws \LogicException
     * @return Reference
     */
    public function pop(): Reference
    {
        if (!\count($this->stack)) {
            throw new \LogicException('Can not pop a json reference from an empty stack');
        }

        return \array_pop($this->stack);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->stack);
    }

    /**
     * @return bool
     */
    public function isNonEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->stack = [];
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return \count($this->stack);
    }

    /**
     * @param Reference $reference
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function isCircularReference(Reference $reference): bool
    {
        ReferenceHelper::assertReferenceNotLocalAndNotRelative($reference);

        foreach ($this->stack as $currentReference) {
            if (0 === \strpos($currentReference->getValue(), $reference->getValue())) {
                return true;
            }
        }

        return false;
    }
}