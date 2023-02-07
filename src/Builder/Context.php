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

use Closure;
use InvalidArgumentException;
use Jojo1981\JsonSchemaAsg\Asg\ObjectSchemaNode;
use Jojo1981\JsonSchemaAsg\Asg\SchemaNode;
use Jojo1981\JsonSchemaAsg\ReferenceResolverInterface;
use Jojo1981\JsonSchemaAsg\Storage\ReferenceLookupTableInterface;
use Jojo1981\JsonSchemaAsg\Storage\SchemaStorageInterface;
use Jojo1981\JsonSchemaAsg\Value\Reference;
use LogicException;
use function call_user_func;

/**
 * This is the context class which hold information during the traversal of the raw schema data tree and have some
 * methods for reading data from other trees and other parts of the current tree
 *
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class Context
{
    /** @var Closure */
    private Closure $resolveSchemaDataRecursivelyCallback;

    /** @var ReferenceLookupTableInterface */
    private ReferenceLookupTableInterface $referenceLookupTable;

    /** @var SchemaStorageInterface */
    private SchemaStorageInterface $schemaStorage;

    /** @var ReferenceResolverInterface */
    private ReferenceResolverInterface $referenceResolver;

    /** @var Reference|null */
    private ?Reference $parentReference = null;

    /** @var ObjectSchemaNode|null */
    private ?ObjectSchemaNode $parentSchemaNode = null;

    /**
     * @param Closure $resolveSchemaDataRecursivelyCallback
     * @param ReferenceLookupTableInterface $referenceLookupTable
     * @param SchemaStorageInterface $schemaStorage
     * @param ReferenceResolverInterface $referenceResolver
     */
    public function __construct(
        Closure $resolveSchemaDataRecursivelyCallback,
        ReferenceLookupTableInterface $referenceLookupTable,
        SchemaStorageInterface $schemaStorage,
        ReferenceResolverInterface $referenceResolver
    ) {
        $this->resolveSchemaDataRecursivelyCallback = $resolveSchemaDataRecursivelyCallback;
        $this->referenceLookupTable = $referenceLookupTable;
        $this->schemaStorage = $schemaStorage;
        $this->referenceResolver = $referenceResolver;
    }

    /**
     * @param array|bool|array[] $schemaData
     * @param Reference $reference
     * @return SchemaNode
     * @throws LogicException
     */
    public function resolveSchemaDataRecursively(
        array|bool $schemaData,
        Reference $reference
    ): SchemaNode {
        if ($this->isCircularReference($reference)) {
            throw new LogicException(
                'Can not resolve schema data for a circular reference. Grab schemaNode form the storage instead'
            );
        }

        return call_user_func(
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
    public function readByReference(Reference $reference): array|bool
    {
        return $this->referenceResolver->readByReference($reference);
    }

    /**
     * @param Reference $reference
     * @return bool
     * @throws InvalidArgumentException
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
