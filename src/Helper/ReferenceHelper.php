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

namespace Jojo1981\JsonSchemaAsg\Helper;

use InvalidArgumentException;
use Jojo1981\JsonSchemaAsg\Value\JsonPointer;
use Jojo1981\JsonSchemaAsg\Value\Reference;
use LogicException;
use UnexpectedValueException;
use function dirname;
use function implode;
use function rtrim;

/**
 * @package Jojo1981\JsonSchemaAsg\Helper
 */
final class ReferenceHelper
{
    /**
     * private constructor to prevent getting an instance of the class
     */
    private function __construct()
    {
        // Nothing to do here
    }

    /**
     * @param string $referenceValue
     * @param Reference $parentReference
     * @throws InvalidArgumentException
     * @throws LogicException
     * @throws UnexpectedValueException
     * @return Reference
     */
    public static function buildAbsoluteReference(string $referenceValue, Reference $parentReference): Reference
    {
        $schemaReference = new Reference($referenceValue);
        if ($schemaReference->isLocal()) {
            $schemaReference = self::createFromUriAndJsonPointer(
                (string) $parentReference->getUri(),
                $schemaReference->getJsonPointer()
            );
        }
        if ($schemaReference->isRelativeFile() && $parentReference->isAbsoluteFile()) {
            $absoluteFilePath = PathHelper::getAbsolutePath(
                $schemaReference->getUri()->getPath(),
                dirname($parentReference->getUri()->getPath())
            );

            $uri = $parentReference->getUri()->withPath($absoluteFilePath);
            $schemaReference = self::createFromUriAndJsonPointer(
                (string) $uri,
                $schemaReference->getJsonPointer()
            );
        }

        return $schemaReference;
    }

    /**
     * @param Reference $reference
     * @param string $key
     * @throws UnexpectedValueException
     * @return Reference
     */
    public static function createFromReferenceByAppendingKey(Reference $reference, string $key): Reference
    {
        return self::createFromUriAndJsonPointer(
            (string) $reference->getUri(),
            self::createFromJsonPointerAndReferenceTokens($reference->getJsonPointer(), [$key])
        );
    }

    /**
     * @param string $uri
     * @param JsonPointer $jsonPointer
     * @throws UnexpectedValueException
     * @return Reference
     */
    public static function createFromUriAndJsonPointer(string $uri, JsonPointer $jsonPointer): Reference
    {
        return new Reference($uri . Reference::FRAGMENT_SEPARATOR . $jsonPointer->getValue());
    }

    /**
     * @param JsonPointer $jsonPointer
     * @param array $referenceTokens
     * @throws UnexpectedValueException
     * @return JsonPointer
     */
    public static function createFromJsonPointerAndReferenceTokens(
        JsonPointer $jsonPointer,
        array $referenceTokens
    ): JsonPointer
    {
        $jsonPointerValue = rtrim($jsonPointer->getValue(), JsonPointer::REFERENCE_TOKEN_SEPARATOR);
        $jsonPointerValue .= JsonPointer::REFERENCE_TOKEN_SEPARATOR;

        return new JsonPointer($jsonPointerValue . self::createReferenceTokenString($referenceTokens));
    }

    /**
     * @param string[] $referenceTokens
     * @return string
     */
    private static function createReferenceTokenString(array $referenceTokens): string
    {
        return implode(JsonPointer::REFERENCE_TOKEN_SEPARATOR, $referenceTokens);
    }

    /**
     * @param Reference $reference
     * @throws InvalidArgumentException
     * @return void
     */
    public static function assertReferenceNotLocalAndNotRelative(Reference $reference): void
    {
        if ($reference->isLocal() || $reference->isRelativeFile()) {
            throw new InvalidArgumentException(
                'Reference may not be local or relative. It must contain and absolute file path or an url'
            );
        }
    }
}
