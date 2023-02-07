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

namespace Jojo1981\JsonSchemaAsg;

use InvalidArgumentException;
use Jojo1981\JsonSchemaAsg\Asg\BooleanSchemaNode;
use Jojo1981\JsonSchemaAsg\Asg\EmptySchemaNode;
use Jojo1981\JsonSchemaAsg\Asg\NodeInterface;
use Jojo1981\JsonSchemaAsg\Asg\ObjectSchemaNode;
use Jojo1981\JsonSchemaAsg\Asg\SchemaNode;
use Jojo1981\JsonSchemaAsg\Builder\BuilderInterface;
use Jojo1981\JsonSchemaAsg\Builder\Context;
use Jojo1981\JsonSchemaAsg\Builder\Exception\BuilderException;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Helper\ReferenceHelper;
use Jojo1981\JsonSchemaAsg\Storage\Exception\StorageException;
use Jojo1981\JsonSchemaAsg\Storage\ReferenceLookupTableInterface;
use Jojo1981\JsonSchemaAsg\Storage\SchemaStorageInterface;
use Jojo1981\JsonSchemaAsg\Value\Reference;
use LogicException;
use UnexpectedValueException;
use function is_array;
use function is_bool;

/**
 * The schema resolver can only resolve schemas when it get a reference passed which contains
 * an absolute file path or http url in it.
 *
 * It will honor the JSON schema draft 07 specification
 * @see http://json-schema.org/draft-07/schema
 *
 * @package Jojo1981\JsonSchemaAsg
 */
class SchemaResolver implements SchemaResolverInterface
{
    /** @var SchemaStorageInterface */
    private SchemaStorageInterface $schemaStorage;

    /** @var ReferenceResolverInterface */
    private ReferenceResolverInterface $referenceResolver;

    /** @var ReferenceLookupTableInterface */
    private ReferenceLookupTableInterface $referenceLookupTable;

    /** @var BuilderInterface */
    private BuilderInterface $builder;

    /**
     * @param SchemaStorageInterface $schemaStorage
     * @param ReferenceResolverInterface $referenceResolver
     * @param ReferenceLookupTableInterface $referenceLookupTable
     * @param BuilderInterface $builder
     */
    public function __construct(
        SchemaStorageInterface $schemaStorage,
        ReferenceResolverInterface $referenceResolver,
        ReferenceLookupTableInterface $referenceLookupTable,
        BuilderInterface $builder
    ) {
        $this->schemaStorage = $schemaStorage;
        $this->referenceResolver = $referenceResolver;
        $this->referenceLookupTable = $referenceLookupTable;
        $this->builder = $builder;
    }

    /**
     * @param Reference $reference
     * @return NodeInterface
     * @throws InvalidArgumentException
     * @throws LogicException
     * @throws UnexpectedValueException
     * @throws StorageException
     */
    public function resolveSchema(Reference $reference): NodeInterface
    {
        ReferenceHelper::assertReferenceNotLocalAndNotRelative($reference);
        $this->referenceLookupTable->clear();
        if (!$this->schemaStorage->has($reference)) {
            $this->resolveSchemaDataRecursively($this->referenceResolver->readByReference($reference), $reference);
        }
        if ($this->referenceLookupTable->isNonEmpty()) {
            throw new LogicException(
                'The reference lookup table should be empty. During the resolve process the reference lookup stack ' .
                'modified from outside this class'
            );
        }

        return $this->schemaStorage->get($reference);
    }

    /**
     * The reference here should always be a remote reference and be an absolute file path or http url. It will be used
     * to determine the context in which file the schema should be resolved.
     *
     * The reference lookup table is needed to determine if we have found a circular reference and avoid getting an
     * infinite loop
     *
     * The storage is to store the already build schema's, so we can get a object reference to them instead of recreating
     * the schemas again and get new instances for them.
     *
     * @param array|bool|array[] $schemaData
     * @param null|ObjectSchemaNode $parentSchemaNode
     * @param Reference $reference
     * @return SchemaNode
     * @throws InvalidArgumentException
     * @throws LogicException
     * @throws UnexpectedValueException
     * @throws StorageException
     */
    private function resolveSchemaDataRecursively(
        array|bool $schemaData,
        Reference $reference,
        ?ObjectSchemaNode $parentSchemaNode = null
    ): SchemaNode {
        ReferenceHelper::assertReferenceNotLocalAndNotRelative($reference);
        if ($this->schemaStorage->has($reference)) {
            $schemaNode = $this->schemaStorage->get($reference);
            if (null !== $parentSchemaNode) {
                $schemaNode->addParent($parentSchemaNode);
            }

            return $schemaNode;
        }

        $schemaNode = $this->buildSchemaNode($schemaData, $parentSchemaNode);
        $this->schemaStorage->add($reference, $schemaNode);

        if ($schemaNode instanceof ObjectSchemaNode) {
            $this->referenceLookupTable->push($reference);
            $this->resolveSchemaData($schemaNode, $reference, $schemaData);
            $this->referenceLookupTable->pop();
        }

        return $schemaNode;
    }

    /**
     * @param ObjectSchemaNode $schemaNode
     * @param Reference $reference
     * @param array $schemaData
     * @return void
     * @throws UnexpectedValueException
     * @throws BuilderException
     */
    private function resolveSchemaData(ObjectSchemaNode $schemaNode, Reference $reference, array $schemaData): void
    {
        foreach ($schemaData as $key => $value) {
            if ($this->builder->acceptKey($key)) {
                $currentReference = ReferenceHelper::createFromReferenceByAppendingKey($reference, $key);
                $this->builder->build($key, $value, $this->buildContext($currentReference, $schemaNode));
            }
        }
    }

    /**
     * @param array|bool|array[] $schemaData
     * @param null|ObjectSchemaNode $parentSchemaNode
     * @return SchemaNode
     * @throws LogicException
     */
    private function buildSchemaNode(array|bool $schemaData, ?ObjectSchemaNode $parentSchemaNode = null): SchemaNode
    {
        if (is_array($schemaData) && empty($schemaData)) {
            return new EmptySchemaNode($parentSchemaNode);
        }
        if (is_bool($schemaData)) {
            return new BooleanSchemaNode($schemaData, $parentSchemaNode);
        }
        if (ArrayHelper::isAssociativeArray($schemaData)) {
            return new ObjectSchemaNode($parentSchemaNode);
        }
        throw new LogicException('Invalid schema passed. A schema must be a boolean value or an object');
    }

    /**
     * @param Reference $parentReference
     * @param ObjectSchemaNode $parentSchemaNode
     * @return Context
     */
    private function buildContext(Reference $parentReference, ObjectSchemaNode $parentSchemaNode): Context
    {
        $callback = function ($schemaData, Reference $reference, ObjectSchemaNode $parentSchemaNode) {
            return $this->resolveSchemaDataRecursively($schemaData, $reference, $parentSchemaNode);
        };

        $context = new Context($callback, $this->referenceLookupTable, $this->schemaStorage, $this->referenceResolver);
        $context->setParentReference($parentReference);
        $context->setParentSchemaNode($parentSchemaNode);

        return $context;
    }
}
