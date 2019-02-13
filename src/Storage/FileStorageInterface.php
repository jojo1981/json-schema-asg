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

use Jojo1981\JsonSchemaAsg\Storage\Exception\StorageException;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;

/**
 * This interface describes a file storage which can be used by the cached file reader to prevent unnecessary file
 * read from disc or from the network/internet
 *
 * @package Jojo1981\JsonSchemaAsg\Storage
 */
interface FileStorageInterface
{
    /**
     * Add schema data for the passed uri into the store
     *
     * @param UriInterface $uri
     * @param bool|array|array[] $schemaData
     * @throws StorageException when there is already schema data for the passed filename in this store
     * @return void
     */
    public function add(UriInterface $uri, $schemaData): void;

    /**
     * Check if there is schema data for the passed uri available in the store
     *
     * @param UriInterface $uri
     * @return bool
     */
    public function has(UriInterface $uri): bool;

    /**
     * @param UriInterface $uri
     * @throws StorageException when a there isn't a schema data available in the store for the passed uri
     * @return bool|array|array[]
     */
    public function get(UriInterface $uri);

    /**
     * Clears the store for a fresh start
     *
     * @return void
     */
    public function clear(): void;
}