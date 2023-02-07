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

namespace Jojo1981\JsonSchemaAsg\PreProcessor;

use InvalidArgumentException;
use Jojo1981\JsonSchemaAsg\Helper\PathHelper;
use Jojo1981\JsonSchemaAsg\Helper\ReferenceHelper;
use Jojo1981\JsonSchemaAsg\Helper\UriHelper;
use Jojo1981\JsonSchemaAsg\PreProcessor\Exception\PreProcessException;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;
use Jojo1981\JsonSchemaAsg\Value\Reference;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;
use LogicException;
use stdClass;
use UnexpectedValueException;
use function array_key_exists;
use function gettype;
use function is_array;
use function is_bool;
use function is_string;
use function json_decode;
use function json_encode;
use function str_starts_with;

/**
 * This preprocessor will rewrite all locally found `$ref` values. The context should be whole json schema content of 1
 * retrieved json schema file. All values will be rewritten, so they contain an absolute json reference. The `$ref`
 * values which are in fact an identifier and nota  json references containing a valid json pointer are also
 * rewritten to
 *
 * @package Jojo1981\JsonSchemaAsg\PreProcessor
 */
class SchemaDataPreprocessor implements SchemaDataPreprocessorInterface
{
    /** @var string */
    public const CUSTOM_KEY_ORIGINAL_REF = 'originalRef';

    /** @var string */
    public const CUSTOM_KEY_ABSOLUTE_REF = 'absoluteRef';

    /**
     * Preprocess the schema data and returned the updated schema data.
     *
     * @param UriInterface $uri
     * @param array|bool|array[] $schemaData
     * @return bool|array|array[]
     * @throws InvalidArgumentException
     * @throws LogicException
     * @throws UnexpectedValueException
     * @throws PreProcessException
     */
    public function preProcess(UriInterface $uri, array|bool $schemaData): array|bool
    {
        $this->assertUriAndSchemaData($uri, $schemaData);
        if (is_bool($schemaData)) {
            return $schemaData;
        }

        $schemaData = $this->processRawSchemaData($schemaData);
        $index = $this->getIdentifierIndex($schemaData);

        return $this->processRecursive((string) $uri, $schemaData, $index);
    }

    /**
     * Process the schema data recursively and return the updated schema data
     *
     * @param string $id
     * @param array $schemaData
     * @param array $index
     * @return array
     * @throws InvalidArgumentException
     * @throws LogicException
     * @throws UnexpectedValueException
     * @throws PreProcessException
     */
    private function processRecursive(string $id, array $schemaData, array $index): array
    {
        if (array_key_exists(JsonKeys::KEY_ID, $schemaData)) {
            $id = $schemaData[JsonKeys::KEY_ID];
            if (!is_string($id)) {
                throw PreProcessException::invalidIdValueTypeFound();
            }
        }

        $result = [];
        foreach ($schemaData as $key => $value) {
            if (is_array($value)) {
                $value = $this->processRecursive($id, $value, $index);
            } else {
                if (JsonKeys::KEY_REF === $key) {
                    if (!is_string($value)) {
                        throw PreProcessException::invalidRefValueTypeFound();
                    }
                    try {
                        $reference = $this->getReferenceFromIndexAndRefValue($index, $value);
                    } catch (UnexpectedValueException $exception) {
                        throw PreProcessException::invalidRefValueFound($id, $value, $exception);
                    }
                    $rewrittenReference = $this->rewriteReferenceWhenNeeded($reference, $id);

                    $value = [
                        self::CUSTOM_KEY_ORIGINAL_REF => $value,
                        self::CUSTOM_KEY_ABSOLUTE_REF => $rewrittenReference->getValue()
                    ];
                }
            }
            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * Return a new rewritten reference when needed or the already passed reference in case it's already a remote
     * json reference and not contain a relative path but is an absolute reference
     *
     * @param Reference $reference
     * @param string $id
     * @return Reference
     * @throws LogicException
     * @throws UnexpectedValueException
     * @throws InvalidArgumentException
     */
    private function rewriteReferenceWhenNeeded(Reference $reference, string $id): Reference
    {
        if ($reference->isLocal()) {
            $reference = ReferenceHelper::createFromUriAndJsonPointer(
                (string) UriHelper::createFromString($id),
                $reference->getJsonPointer()
            );
        } else {
            if ($reference->isRemote() && $reference->isRelativeFile()) {
                $reference = ReferenceHelper::buildAbsoluteReference(
                    $reference->getValue(),
                    new Reference($id . '#/')
                );
            }
        }

        return $reference;
    }

    /**
     * Get a Reference object based on the passed $value. If the value points to an identifier the earlier resolved
     * local reference with only a json pointer will be used to build the Reference
     *
     * @param string[] $index
     * @param string $refValue
     * @return Reference
     * @throws PreProcessException
     * @throws UnexpectedValueException
     */
    private function getReferenceFromIndexAndRefValue(array $index, string $refValue): Reference
    {
        if ($this->isIdentifier($refValue)) {
            if (!array_key_exists($refValue, $index)) {
                throw PreProcessException::invalidRefValueWhichPointToNoExistingIdentifierFound($refValue);
            }
            $refValue = $index[$refValue];
        }

        return new Reference($refValue);
    }

    /**
     * This method will resolve all `$id` values which not contain an uri but an identifier value. It will build an
     * index of all found values and build a map with the identifier value as key and the value has the corresponding
     * local json reference (a reference which only contains a json pointer)
     *
     * @param array[] $schemaData
     * @param string[] $index
     * @param string $path
     * @return string[]
     */
    private function getIdentifierIndex(array $schemaData, array &$index = [], string $path = '#'): array
    {
        foreach ($schemaData as $key => $value) {
            $currentPath = $path . '/' . $key;
            if (is_array($value)) {
                $this->getIdentifierIndex($value, $index, $currentPath);
            }
            if (is_string($value) && JsonKeys::KEY_ID === $key && $this->isIdentifier($value)) {
                $index[$value] = $path;
            }
        }

        return $index;
    }

    /**
     * Check if the value passed is not a json pointer or uri but should be handled as an identifier
     *
     * @param string $value
     * @return bool
     */
    private function isIdentifier(string $value): bool
    {
        return str_starts_with($value, '#') && !str_starts_with($value, '#/');
    }

    /**
     * @param UriInterface $uri
     * @param array|bool|array[] $schemaData
     * @return void
     * @throws PreProcessException
     */
    private function assertUriAndSchemaData(UriInterface $uri, array|bool $schemaData): void
    {
        if (!is_bool($schemaData) && !is_array($schemaData)) {
            throw PreProcessException::invalidSchemaDataFound(gettype($schemaData));
        }
        if (!PathHelper::isAbsolute($uri->getPath())) {
            throw PreProcessException::invalidUriPassed($uri);
        }
    }

    /**
     * Make sure that the nested schema data is a nested array which only has array values and doesn't contain any
     * `\stdClass` objects. This is needed because the schema retriever can be exchanged for another one which will
     * return an array which has \stdClass object in the nested structure.
     *
     * @param stdClass|array|array[] $rawSchemaData
     * @return array[]
     */
    private function processRawSchemaData(array|stdClass $rawSchemaData): array
    {
        return json_decode(json_encode($rawSchemaData), true);
    }
}
