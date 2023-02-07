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

use Jojo1981\JsonSchemaAsg\Value\JsonPointer;
use UnexpectedValueException;
use function implode;

/**
 * @package Jojo1981\JsonSchemaAsg\Helper
 */
final class JsonPointerHelper
{
    /**
     * private constructor to prevent getting an instance of the class
     */
    private function __construct()
    {
        // Nothing to do here
    }
    /**
     * @param string[] $referenceTokens
     * @throws UnexpectedValueException
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
        return implode(
            JsonPointer::REFERENCE_TOKEN_SEPARATOR,
            ReferenceTokenParser::denormalizeReferenceTokens($referenceTokens)
        );
    }
}
