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

namespace Jojo1981\JsonSchemaAsg\Retriever;

use Jojo1981\JsonSchemaAsg\Retriever\Exception\RetrieverException;
use Jojo1981\JsonSchemaAsg\Storage\Exception\StorageException;
use Jojo1981\JsonSchemaAsg\Storage\FileStorageInterface;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;

/**
 * This decorator is responsible for storing the retrieved schema data to the file storage and prevent unnecessary disc
 * io and or network/internet traffic
 *
 * @package Jojo1981\JsonSchemaAsg\Retriever
 */
class FileStorageSchemaRetrieverDecorator implements SchemaRetrieverInterface
{
    /** @var SchemaRetrieverInterface */
    private SchemaRetrieverInterface $schemaRetriever;

    /** @var FileStorageInterface */
    private FileStorageInterface $fileStorage;

    /**
     * @param SchemaRetrieverInterface $schemaRetriever
     * @param FileStorageInterface $fileStorage
     */
    public function __construct(SchemaRetrieverInterface $schemaRetriever, FileStorageInterface $fileStorage)
    {
        $this->schemaRetriever = $schemaRetriever;
        $this->fileStorage = $fileStorage;
    }

    /**
     * @param UriInterface $uri
     * @throws RetrieverException
     * @throws StorageException
     * @return array|array[]|bool
     */
    public function readSchemaDataFromUri(UriInterface $uri): array|bool
    {
        if (!$this->fileStorage->has($uri)) {
            $this->fileStorage->add($uri, $this->schemaRetriever->readSchemaDataFromUri($uri));
        }

        return $this->fileStorage->get($uri);
    }
}
