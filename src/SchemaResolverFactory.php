<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg;

use Jojo1981\JsonSchemaAsg\Exception\JsonSchemaAsgException;
use Jojo1981\JsonSchemaAsg\PreProcessor\SchemaDataPreprocessor;
use Jojo1981\JsonSchemaAsg\PreProcessor\SchemaDataPreprocessorInterface;
use Jojo1981\JsonSchemaAsg\Retriever\FileStorageSchemaRetrieverDecorator;
use Jojo1981\JsonSchemaAsg\Retriever\PreProcessSchemaRetrieverDecorator;
use Jojo1981\JsonSchemaAsg\Retriever\SchemaRetriever;
use Jojo1981\JsonSchemaAsg\Retriever\SchemaRetrieverInterface;
use Jojo1981\JsonSchemaAsg\Storage\FileStorage;
use Jojo1981\JsonSchemaAsg\Storage\FileStorageInterface;
use Jojo1981\JsonSchemaAsg\Storage\ReferenceLookupTable;
use Jojo1981\JsonSchemaAsg\Storage\ReferenceLookupTableInterface;
use Jojo1981\JsonSchemaAsg\Storage\SchemaStorage;
use Jojo1981\JsonSchemaAsg\Storage\SchemaStorageInterface;

/**
 * This factory is useful for easy getting started with the SchemaResolver and will do the basic setup and build you
 * a SchemaResolver
 *
 * @package Jojo1981\JsonSchemaAsg
 */
class SchemaResolverFactory
{
    /** @var SchemaStorageInterface */
    private $schemaStorage;

    /** @var SchemaRetrieverInterface */
    private $schemaRetriever;

    /** @var ReferenceResolverInterface */
    private $referenceResolver;

    /** @var ReferenceLookupTableInterface */
    private $referenceLookupTable;

    /** @var BuilderRegistry */
    private $builderRegistry;

    /** @var FileStorageInterface */
    private $fileStorage;

    /** @var SchemaDataPreprocessorInterface */
    private $preProcessor;

    /** @var bool */
    private $frozen = false;

    /**
     * @param FileStorageInterface $fileStorage
     * @throws JsonSchemaAsgException
     * @return $this
     */
    public function setFileStorage(FileStorageInterface $fileStorage): self
    {
        $this->assertNotFrozen();
        $this->fileStorage = $fileStorage;

        return $this;
    }

    /**
     * @param SchemaStorageInterface $schemaStorage
     * @throws JsonSchemaAsgException
     * @return $this
     */
    public function setSchemaStorage(SchemaStorageInterface $schemaStorage): self
    {
        $this->assertNotFrozen();
        $this->schemaStorage = $schemaStorage;

        return $this;
    }

    /**
     * @param SchemaRetrieverInterface $schemaRetriever
     * @throws JsonSchemaAsgException
     * @return $this
     */
    public function setSchemaRetriever(SchemaRetrieverInterface $schemaRetriever): self
    {
        $this->assertNotFrozen();
        $this->schemaRetriever = $schemaRetriever;

        return $this;
    }

    /**
     * @param ReferenceResolverInterface $referenceResolver
     * @throws JsonSchemaAsgException
     * @return $this
     */
    public function setReferenceResolver(ReferenceResolverInterface $referenceResolver): self
    {
        $this->assertNotFrozen();
        $this->referenceResolver = $referenceResolver;

        return $this;
    }

    /**
     * @param ReferenceLookupTableInterface $referenceLookupTable
     * @throws JsonSchemaAsgException
     * @return $this
     */
    public function setReferenceLookupTable(ReferenceLookupTableInterface $referenceLookupTable): self
    {
        $this->assertNotFrozen();
        $this->referenceLookupTable = $referenceLookupTable;

        return $this;
    }

    /**
     * @param BuilderRegistry $builderRegistry
     * @throws JsonSchemaAsgException
     * @return $this
     */
    public function setBuilderRegistry(BuilderRegistry $builderRegistry): self
    {
        $this->assertNotFrozen();
        $this->builderRegistry = $builderRegistry;

        return $this;
    }

    /**
     * @throws \LogicException
     * @return SchemaResolverInterface
     */
    public function getSchemaResolver(): SchemaResolverInterface
    {
        $this->frozen = true;

        return new SchemaResolver(
            $this->getSchemaStorage(),
            $this->getReferenceResolver(),
            $this->getReferenceLookupTable(),
            $this->getBuilderRegistry()
        );
    }

    /**
     * @return ReferenceResolverInterface
     */
    public function getReferenceResolver(): ReferenceResolverInterface
    {
        $this->frozen = true;

        if (!$this->referenceResolver) {
            $this->referenceResolver = new ReferenceResolver($this->getSchemaRetriever());
        }

        return $this->referenceResolver;
    }

    /**
     * @return SchemaRetrieverInterface
     */
    public function getSchemaRetriever(): SchemaRetrieverInterface
    {
        $this->frozen = true;

        if (!$this->schemaRetriever) {
            $this->schemaRetriever = new SchemaRetriever();
        }

        return new FileStorageSchemaRetrieverDecorator(
            new PreProcessSchemaRetrieverDecorator(
                $this->schemaRetriever,
                $this->getPreProcessor()
            ),
            $this->getFileStorage()
        );
    }

    /**
     * @return SchemaStorageInterface
     */
    private function getSchemaStorage(): SchemaStorageInterface
    {
        if (!$this->schemaStorage) {
            $this->schemaStorage = new SchemaStorage();
        }

        return $this->schemaStorage;
    }

    /**
     * @return ReferenceLookupTableInterface
     */
    private function getReferenceLookupTable(): ReferenceLookupTableInterface
    {
        if (!$this->referenceLookupTable) {
            $this->referenceLookupTable = new ReferenceLookupTable();
        }

        return $this->referenceLookupTable;
    }

    /**
     * @throws \LogicException
     * @return BuilderRegistry
     */
    private function getBuilderRegistry(): BuilderRegistry
    {
        if (!$this->builderRegistry) {
            $this->builderRegistry = BuilderRegistry::createDefaultBuilderRegistry();
        }

        return $this->builderRegistry;
    }

    /**
     * @return FileStorageInterface
     */
    private function getFileStorage(): FileStorageInterface
    {
        if (!$this->fileStorage) {
            $this->fileStorage = new FileStorage();
        }

        return $this->fileStorage;
    }

    /**
     * @return SchemaDataPreprocessorInterface
     */
    private function getPreProcessor(): SchemaDataPreprocessorInterface
    {
        if (!$this->preProcessor) {
            $this->preProcessor = new SchemaDataPreprocessor();
        }

        return $this->preProcessor;
    }

    /**
     * @throws JsonSchemaAsgException
     * @return void
     */
    private function assertNotFrozen(): void
    {
        if ($this->frozen) {
            throw new JsonSchemaAsgException(
                'SchemaResolverFactory is frozen. So no setter methods can be called anymore. ' .
                'The factory will be frozen after one of the getter methods has been called.'
            );
        }
    }
}