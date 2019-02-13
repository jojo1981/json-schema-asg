<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\PreProcessor;

use Jojo1981\JsonSchemaAsg\PreProcessor\Exception\PreProcessException;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;

/**
 * This interface describes an interface for json schema data pre processors. The preprocessors can be used directly
 * after retrieving the json schema data before it will be cached. They can be used to index data and/or resolved `$id`
 * and `$ref` values.
 *
 * @package Jojo1981\JsonSchemaAsg\PreProcessor
 */
interface SchemaDataPreprocessorInterface
{
    /**
     * Preprocess the schema data and returned the updated schema data
     *
     * @param UriInterface $uri
     * @param bool|array|array[] $schemaData
     * @throws PreProcessException
     * @return bool|array|array[]
     */
    public function preProcess(UriInterface $uri, $schemaData);
}