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

use Jojo1981\JsonSchemaAsg\PreProcessor\Exception\PreProcessException;
use Jojo1981\JsonSchemaAsg\PreProcessor\SchemaDataPreprocessorInterface;
use Jojo1981\JsonSchemaAsg\Retriever\Exception\RetrieverException;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;

/**
 * This decorator is responsible for pre-processing the retrieved data from the schema retriever using a pre-processor.
 * When using this decorator in combination with the file storage schema retriever decorator this decorator should be
 * used first and then the other should be wrapped around this decorator. So the processed schema data will be cached and
 * not the raw data.
 *
 * @package Jojo1981\JsonSchemaAsg\Retriever
 */
class PreProcessSchemaRetrieverDecorator implements SchemaRetrieverInterface
{
    /** @var SchemaRetrieverInterface */
    private SchemaRetrieverInterface $schemaRetriever;

    /** @var SchemaDataPreprocessorInterface */
    private SchemaDataPreprocessorInterface $schemaDataPreprocessor;

    /**
     * @param SchemaRetrieverInterface $schemaRetriever
     * @param SchemaDataPreprocessorInterface $schemaDataPreprocessor
     */
    public function __construct(
        SchemaRetrieverInterface $schemaRetriever,
        SchemaDataPreprocessorInterface $schemaDataPreprocessor
    ) {
        $this->schemaRetriever = $schemaRetriever;
        $this->schemaDataPreprocessor = $schemaDataPreprocessor;
    }

    /**
     * @param UriInterface $uri
     * @throws RetrieverException
     * @throws PreProcessException
     * @return bool|array|array[]
     */
    public function readSchemaDataFromUri(UriInterface $uri): array|bool
    {
        return $this->schemaDataPreprocessor->preProcess($uri, $this->schemaRetriever->readSchemaDataFromUri($uri));
    }
}
