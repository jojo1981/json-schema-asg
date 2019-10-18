<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\Storage\Exception;

use Jojo1981\JsonSchemaAsg\Value\Reference;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;

/**
 * This is the base class for all exceptions thrown during the storage of raw json schema data and storing the
 * build schema nodes
 *
 * @package Jojo1981\JsonSchemaAsg\Storage\Exception
 */
class StorageException extends \LogicException
{
    /**
     * @param UriInterface $uri
     * @return StorageException
     */
    public static function alreadyExistsForUriException(UriInterface $uri): StorageException
    {
        return new self(\sprintf('Already stored a schema for file: %s', (string) $uri));
    }

    /**
     * @param UriInterface $uri
     * @return StorageException
     */
    public static function noSchemaDataForUriExistsException(UriInterface $uri): StorageException
    {
        return new self(\sprintf('No schema data for file: %s available in the storage', (string) $uri));
    }

    /**
     * @param Reference $reference
     * @return StorageException
     */
    public static function alreadyExistsForSchemaReferenceException(Reference $reference): StorageException
    {
        return new self(\sprintf('Already stored a schema for reference: %s', $reference->getValue()));
    }

    /**
     * @param Reference $reference
     * @return StorageException
     */
    public static function noSchemaForSchemaReferenceExistsException(Reference $reference): StorageException
    {
        return new self(\sprintf('No schema with reference: %s available in the storage', $reference->getValue()));
    }
}