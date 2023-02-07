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

use function array_map;
use function str_replace;

/**
 * This helper class contains static functions for normalize and denormalize json pointer reference tokens.
 * @see https://tools.ietf.org/html/rfc6901
 *
 * @package Jojo1981\JsonSchemaAsg
 */
final class ReferenceTokenParser
{
    /**
     * private constructor to prevent getting an instance of the class
     */
    private function __construct()
    {
        // Nothing to do here
    }

    /**
     * @param string $referenceToken
     * @return string
     */
    public static function normalizeReferenceToken(string $referenceToken): string
    {
        return str_replace(['~0', '~1'], ['~', '/'], $referenceToken);
    }

    /**
     * @param string $referenceToken
     * @return string
     */
    public static function denormalizeReferenceToken(string $referenceToken): string
    {
        return str_replace(['~', '/'], ['~0', '~1'] , $referenceToken);
    }

    /**
     * @param string[] $referenceTokens
     * @return string[]
     */
    public static function normalizeReferenceTokens(array $referenceTokens): array
    {
        return array_map(
            function (string $referenceToken): string {
                return self::normalizeReferenceToken($referenceToken);
            },
            $referenceTokens
        );
    }

    /**
     * @param string[] $referenceTokens
     * @return string[]
     */
    public static function denormalizeReferenceTokens(array $referenceTokens): array
    {
        return array_map(
            function (string $referenceToken): string {
                return self::denormalizeReferenceToken($referenceToken);
            },
            $referenceTokens
        );
    }
}
