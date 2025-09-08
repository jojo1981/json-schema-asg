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

use Jojo1981\JsonSchemaAsg\Asg\SchemaNode;
use Jojo1981\JsonSchemaAsg\Storage\Exception\StorageException;
use Jojo1981\JsonSchemaAsg\Value\Reference;

/**
 * This interface describes the schema storage which will be used for storing schemas during the resolve process.
 * By using this store an object reference to schema can be retrieved a prevented that a new schema will be read
 * using the file reader and a new schema object will be created.
 *
 * @package Jojo1981\JsonSchemaAsg\Storage
 */
interface SchemaStorageInterface
{
    /**
     * Add a schema for the passed reference into the store
     *
     * @param Reference $reference
     * @param SchemaNode $schema
     * @throws StorageException when a schema for the passed reference is already stored
     * @return void
     */
    public function add(Reference $reference, SchemaNode $schema): void;

    /**
     * Check if a schema for the passed reference is available in the store
     *
     * @param Reference $reference
     * @return bool
     */
    public function has(Reference $reference): bool;

    /**
     * @param Reference $reference
     * @throws StorageException when a there isn't a schema available in the store for the passed reference
     * @return SchemaNode
     */
    public function get(Reference $reference): SchemaNode;

    /**
     * Clears the store for a fresh start
     *
     * @return void
     */
    public function clear(): void;
}
