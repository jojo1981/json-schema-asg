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

use Jojo1981\JsonSchemaAsg\Helper\ReferenceHelper;
use Jojo1981\JsonSchemaAsg\Retriever\Exception\RetrieverException;
use Jojo1981\JsonSchemaAsg\Retriever\SchemaRetrieverInterface;
use Jojo1981\JsonSchemaAsg\Value\Reference;

/**
 * This class is responsible for delegating the retrieval and parsing of the schema data to the retriever but will
 * return a sub node from it when it's being asked in the passed reference based on the json pointer in it.
 *
 * @package Jojo1981\JsonSchemaAsg
 */
class ReferenceResolver implements ReferenceResolverInterface
{
    /** @var SchemaRetrieverInterface */
    private $schemaRetriever;

    /**
     * @param SchemaRetrieverInterface $schemaRetriever
     */
    public function __construct(SchemaRetrieverInterface $schemaRetriever)
    {
        $this->schemaRetriever = $schemaRetriever;
    }

    /**
     * @param Reference $reference
     * @throws RetrieverException
     * @throws \InvalidArgumentException
     * @throws \LogicException
     * @return bool|array|array[]
     */
    public function readByReference(Reference $reference)
    {
        ReferenceHelper::assertReferenceNotLocalAndNotRelative($reference);

        $schemaData = $this->schemaRetriever->readSchemaDataFromUri($reference->getUri());
        if (!\is_array($schemaData)) {
            throw new \LogicException(\sprintf('Can not resolve reference: %s', $reference->getValue()));
        }

        foreach ($reference->getJsonPointer()->getReferenceTokens() as $referenceToken) {
            if (!\array_key_exists($referenceToken, $schemaData)) {
                throw new \LogicException(\sprintf('Can not resolve reference: %s', $reference->getValue()));
            }
            $schemaData = $schemaData[$referenceToken];
        }

        return $schemaData;
    }
}