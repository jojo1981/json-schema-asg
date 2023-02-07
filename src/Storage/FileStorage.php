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

use Jojo1981\JsonSchemaAsg\Storage\Exception\StorageException;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;
use function array_key_exists;

/**
 * @package Jojo1981\JsonSchemaAsg\Storage
 */
class FileStorage implements FileStorageInterface
{
    /** @var (bool|array|array[])[] */
    private array $cache = [];

    /**
     * @param UriInterface $uri
     * @param array|bool|array[] $schemaData
     * @return void
     *@throws StorageException
     */
    public function add(UriInterface $uri, array|bool $schemaData): void
    {
        if ($this->has($uri)) {
            throw StorageException::alreadyExistsForUriException($uri);
        }
        $this->cache[(string) $uri] = $schemaData;

    }

    /**
     * @param UriInterface $uri
     * @return bool
     */
    public function has(UriInterface $uri): bool
    {
        return array_key_exists((string) $uri, $this->cache);
    }

    /**
     * @param UriInterface $uri
     * @return bool|array|array[]
     * @throws StorageException
     */
    public function get(UriInterface $uri): array|bool
    {
        if (!$this->has($uri)) {
            throw StorageException::noSchemaDataForUriExistsException($uri);
        }

        return $this->cache[(string) $uri];
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->cache = [];
    }
}
