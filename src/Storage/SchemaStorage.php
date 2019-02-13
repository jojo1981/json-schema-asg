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

use Jojo1981\JsonSchemaAsg\Asg\SchemaNode;
use Jojo1981\JsonSchemaAsg\Storage\Exception\StorageException;
use Jojo1981\JsonSchemaAsg\Value\Reference;

/**
 * @package Jojo1981\JsonSchemaAsg\Storage
 */
class SchemaStorage implements SchemaStorageInterface
{
    /** @var SchemaNode[] */
    private $cache = [];

    public function add(Reference $reference, SchemaNode $schema): void
    {
        if ($this->has($reference)) {
            throw StorageException::alreadyExistsForSchemaReferenceException($reference);
        }
        $this->cache[$reference->getValue()] = $schema;
    }

    public function has(Reference $reference): bool
    {
        return \array_key_exists($reference->getValue(), $this->cache);
    }

    public function get(Reference $reference): SchemaNode
    {
        if (!$this->has($reference)) {
            throw StorageException::noSchemaForSchemaReferenceExistsException($reference);
        }

        return $this->cache[$reference->getValue()];
    }

    public function clear(): void
    {
        $this->cache = [];
    }
}