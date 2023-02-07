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
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;

/**
 * This interface describes what the interface is of a schema retriever. A schema retriever is responsible for retrieving
 * the content of a json schema on the local filesystem or the network/internet and responsible for decoding the json schema
 * data.
 *
 * @package Jojo1981\JsonSchemaAsg\Retriever
 */
interface SchemaRetrieverInterface
{
    /**
     * Read schema data from uri and return the json schema data as a nested array
     *
     * @param UriInterface $uri
     * @throws RetrieverException
     * @return bool|array|array[]
     */
    public function readSchemaDataFromUri(UriInterface $uri): array|bool;
}
