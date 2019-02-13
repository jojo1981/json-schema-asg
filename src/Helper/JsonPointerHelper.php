<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\Helper;

use Jojo1981\JsonSchemaAsg\Value\JsonPointer;

/**
 * @package Jojo1981\JsonSchemaAsg\Helper
 */
final class JsonPointerHelper
{
    private function __construct()
    {
        // prevent getting an instance of this class
    }

    /**
     * @param string[] $referenceTokens
     * @throws \UnexpectedValueException
     * @return JsonPointer
     */
    public static function createFromReferenceTokens(array $referenceTokens): JsonPointer
    {
        return new JsonPointer(JsonPointer::REFERENCE_TOKEN_SEPARATOR . self::parseReferenceTokens($referenceTokens));
    }

    /**
     * @param string[] $referenceTokens
     * @return string
     */
    private static function parseReferenceTokens(array $referenceTokens): string
    {
        return \implode(
            JsonPointer::REFERENCE_TOKEN_SEPARATOR,
            ReferenceTokenParser::denormalizeReferenceTokens($referenceTokens)
        );
    }
}