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

    public function getSchemaResolver(): SchemaResolverInterface
    {
        return new SchemaResolver(
            $this->getSchemaStorage(),
            $this->getReferenceResolver(),
            $this->getReferenceLookupTable(),
            $this->getBuilderRegistry()
        );
    }

    public function setSchemaStorage(SchemaStorageInterface $schemaStorage): void
    {
        $this->schemaStorage = $schemaStorage;
    }

    public function setSchemaRetriever(SchemaRetrieverInterface $schemaRetriever): void
    {
        $this->schemaRetriever = $schemaRetriever;
    }

    public function setReferenceResolver(ReferenceResolverInterface $referenceResolver): void
    {
        $this->referenceResolver = $referenceResolver;
    }

    public function setReferenceLookupTable(ReferenceLookupTableInterface $referenceLookupTable): void
    {
        $this->referenceLookupTable = $referenceLookupTable;
    }

    public function setBuilderRegistry(BuilderRegistry $builderRegistry): void
    {
        $this->builderRegistry = $builderRegistry;
    }

    private function getSchemaStorage(): SchemaStorageInterface
    {
        if (!$this->schemaStorage) {
            $this->schemaStorage = new SchemaStorage();
        }

        return $this->schemaStorage;
    }

    private function getSchemaFileReader(): SchemaRetrieverInterface
    {
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

    public function getReferenceResolver(): ReferenceResolverInterface
    {
        if (!$this->referenceResolver) {
            $this->referenceResolver = new ReferenceResolver($this->getSchemaFileReader());
        }

        return $this->referenceResolver;
    }

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
}