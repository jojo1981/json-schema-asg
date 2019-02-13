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

use Jojo1981\JsonSchemaAsg\Asg\ObjectSchemaNode;
use Jojo1981\JsonSchemaAsg\Asg\SchemaNode;
use Jojo1981\JsonSchemaAsg\ReferenceResolverInterface;
use Jojo1981\JsonSchemaAsg\Storage\ReferenceLookupTableInterface;
use Jojo1981\JsonSchemaAsg\Storage\SchemaStorageInterface;
use Jojo1981\JsonSchemaAsg\Value\Reference;

/**
 * This is the context class which hold information during the traversal of the raw schema data tree and have some
 * methods for reading data from other trees and other parts of the current tree
 *
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class Context
{
    /** @var \Closure */
    private $resolveSchemaDataRecursivelyCallback;

    /** @var ReferenceLookupTableInterface */
    private $referenceLookupTable;

    /** @var SchemaStorageInterface */
    private $schemaStorage;

    /** @var ReferenceResolverInterface */
    private $referenceResolver;

    /** @var Reference */
    private $parentReference;

    /** @var ObjectSchemaNode */
    private $parentSchemaNode;

    /**
     * @param \Closure $resolveSchemaDataRecursivelyCallback
     * @param ReferenceLookupTableInterface $referenceLookupTable
     * @param SchemaStorageInterface $schemaStorage
     * @param ReferenceResolverInterface $referenceResolver
     */
    public function __construct(
        \Closure $resolveSchemaDataRecursivelyCallback,
        ReferenceLookupTableInterface
        $referenceLookupTable,
        SchemaStorageInterface $schemaStorage,
        ReferenceResolverInterface $referenceResolver
    ) {
        $this->resolveSchemaDataRecursivelyCallback = $resolveSchemaDataRecursivelyCallback;
        $this->referenceLookupTable = $referenceLookupTable;
        $this->schemaStorage = $schemaStorage;
        $this->referenceResolver = $referenceResolver;
    }

    /**
     * @param bool|array|array[] $schemaData
     * @param Reference $reference
     * @throws \LogicException
     * @return SchemaNode
     */
    public function resolveSchemaDataRecursively(
        $schemaData,
        Reference $reference
    ): SchemaNode
    {
        if ($this->isCircularReference($reference)) {
            throw new \LogicException(
                'Can not resolve schema data for a circular reference. Grab schemaNode form the storage instead'
            );
        }

        return \call_user_func(
            $this->resolveSchemaDataRecursivelyCallback,
            $schemaData,
            $reference,
            $this->parentSchemaNode
        );
    }

    /**
     * @param Reference $reference
     * @return bool|array|array[]
     */
    public function readByReference(Reference $reference)
    {
        return $this->referenceResolver->readByReference($reference);
    }

    /**
     * @param Reference $reference
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function isCircularReference(Reference $reference): bool
    {
        return $this->referenceLookupTable->isCircularReference($reference);
    }

    /**
     * @return SchemaStorageInterface
     */
    public function getSchemaStorage(): SchemaStorageInterface
    {
        return $this->schemaStorage;
    }

    /**
     * @return Reference
     */
    public function getParentReference(): Reference
    {
        return $this->parentReference;
    }

    /**
     * @param Reference $parentReference
     * @return void
     */
    public function setParentReference(Reference $parentReference): void
    {
        $this->parentReference = $parentReference;
    }

    /**
     * @return ObjectSchemaNode
     */
    public function getParentSchemaNode(): ObjectSchemaNode
    {
        return $this->parentSchemaNode;
    }

    /**
     * @param ObjectSchemaNode $parentSchemaNode
     * @return void
     */
    public function setParentSchemaNode(ObjectSchemaNode $parentSchemaNode): void
    {
        $this->parentSchemaNode = $parentSchemaNode;
    }
}