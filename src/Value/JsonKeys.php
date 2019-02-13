<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\Value;

/**
 * @package Jojo1981\JsonSchemaAsg\Value
 */
final class JsonKeys
{
    public const KEY_TYPE = 'type';
    public const KEY_DEFINITIONS = 'definitions';
    public const KEY_DEFAULT = 'default';
    public const KEY_CONST = 'const';
    public const KEY_ENUM = 'enum';
    public const KEY_EXAMPLES = 'examples';
    public const KEY_DEPENDENCIES = 'dependencies';
    public const KEY_ITEMS = 'items';
    public const KEY_PATTERN_PROPERTIES = 'patternProperties';
    public const KEY_PROPERTIES = 'properties';
    public const KEY_REF = '$ref';
    public const KEY_REQUIRED = 'required';
    public const KEY_ID = '$id';
    public const KEY_SCHEMA = '$schema';
    public const KEY_COMMENT = '$comment';
    public const KEY_VERSION = '$version';
    public const KEY_TITLE = 'title';
    public const KEY_DESCRIPTION = 'description';
    public const KEY_PATTERN = 'pattern';
    public const KEY_FORMAT = 'format';
    public const KEY_CONTENT_MEDIA_TYPE = 'contentMediaType';
    public const KEY_CONTENT_ENCODING = 'contentEncoding';
    public const KEY_READ_ONLY = 'readOnly';
    public const KEY_UNIQUE_ITEMS = 'uniqueItems';
    public const KEY_ALL_OF = 'allOf';
    public const KEY_ANY_OF = 'anyOf';
    public const KEY_ONE_OF = 'oneOf';
    public const KEY_ADDITIONAL_ITEMS = 'additionalItems';
    public const KEY_CONTAINS = 'contains';
    public const KEY_ADDITIONAL_PROPERTIES = 'additionalProperties';
    public const KEY_PROPERTY_NAMES = 'propertyNames';
    public const KEY_IF = 'if';
    public const KEY_THEN = 'then';
    public const KEY_ELSE = 'else';
    public const KEY_NOT = 'not';
    public const KEY_MAX_LENGTH = 'maxLength';
    public const KEY_MIN_LENGTH = 'minLength';
    public const KEY_MAX_ITEMS = 'maxItems';
    public const KEY_MIN_ITEMS = 'minItems';
    public const KEY_MAX_PROPERTIES = 'maxProperties';
    public const KEY_MIN_PROPERTIES = 'minProperties';
    public const KEY_MULTIPLE_OF =  'multipleOf';
    public const KEY_MAXIMUM =  'maximum';
    public const KEY_EXCLUSIVE_MAXIMUM =  'exclusiveMaximum';
    public const KEY_MINIMUM =  'minimum';
    public const KEY_EXCLUSIVE_MINIMUM = 'exclusiveMinimum';

    private function __construct()
    {
        // prevent getting an instance of the class
    }

    /**
     * @return string[]
     */
    public static function getKeys(): array
    {
        return [
            self::KEY_TYPE,
            self::KEY_DEFINITIONS,
            self::KEY_DEFAULT,
            self::KEY_CONST,
            self::KEY_ENUM,
            self::KEY_EXAMPLES,
            self::KEY_DEPENDENCIES,
            self::KEY_ITEMS,
            self::KEY_PATTERN_PROPERTIES,
            self::KEY_PROPERTIES,
            self::KEY_REF,
            self::KEY_REQUIRED,
            self::KEY_ID,
            self::KEY_SCHEMA,
            self::KEY_COMMENT,
            self::KEY_VERSION,
            self::KEY_TITLE,
            self::KEY_DESCRIPTION,
            self::KEY_PATTERN,
            self::KEY_FORMAT,
            self::KEY_CONTENT_MEDIA_TYPE,
            self::KEY_CONTENT_ENCODING,
            self::KEY_READ_ONLY,
            self::KEY_UNIQUE_ITEMS,
            self::KEY_ALL_OF,
            self::KEY_ANY_OF,
            self::KEY_ONE_OF,
            self::KEY_ADDITIONAL_ITEMS,
            self::KEY_CONTAINS,
            self::KEY_ADDITIONAL_PROPERTIES,
            self::KEY_PROPERTY_NAMES,
            self::KEY_IF,
            self::KEY_THEN,
            self::KEY_ELSE,
            self::KEY_NOT,
            self::KEY_MAX_LENGTH,
            self::KEY_MIN_LENGTH,
            self::KEY_MAX_ITEMS,
            self::KEY_MIN_ITEMS,
            self::KEY_MAX_PROPERTIES,
            self::KEY_MIN_PROPERTIES,
            self::KEY_MULTIPLE_OF,
            self::KEY_MAXIMUM,
            self::KEY_EXCLUSIVE_MAXIMUM,
            self::KEY_MINIMUM,
            self::KEY_EXCLUSIVE_MINIMUM
        ];
    }

    /**
     * @return string[]
     */
    public static function getBooleanKeys(): array
    {
        return [self::KEY_READ_ONLY, self::KEY_UNIQUE_ITEMS];
    }

    /**
     * @return string[]
     */
    public static function getStringKeys(): array
    {
        return [
            self::KEY_ID,
            self::KEY_SCHEMA,
            self::KEY_COMMENT,
            self::KEY_VERSION,
            self::KEY_TITLE,
            self::KEY_DESCRIPTION,
            self::KEY_PATTERN,
            self::KEY_FORMAT,
            self::KEY_CONTENT_MEDIA_TYPE,
            self::KEY_CONTENT_ENCODING
        ];
    }

    /**
     * @return string[]
     */
    public static function getIntegerKeys(): array
    {
        return [
            self::KEY_MAX_LENGTH,
            self::KEY_MIN_LENGTH,
            self::KEY_MAX_ITEMS,
            self::KEY_MIN_ITEMS,
            self::KEY_MAX_PROPERTIES,
            self::KEY_MIN_PROPERTIES,
        ];
    }

    /**
     * @return string[]
     */
    public static function getNumberKeys(): array
    {
        return [
            self::KEY_MULTIPLE_OF,
            self::KEY_MAXIMUM,
            self::KEY_EXCLUSIVE_MAXIMUM,
            self::KEY_MINIMUM,
            self::KEY_EXCLUSIVE_MINIMUM
        ];
    }

    /**
     * @return string[]
     */
    public static function getSingleSchemaKeys(): array
    {
        return [
            self::KEY_ADDITIONAL_ITEMS,
            self::KEY_CONTAINS,
            self::KEY_ADDITIONAL_PROPERTIES,
            self::KEY_PROPERTY_NAMES,
            self::KEY_IF,
            self::KEY_THEN,
            self::KEY_ELSE,
            self::KEY_NOT
        ];
    }

    /**
     * @return string[]
     */
    public static function getSequenceOfSchemasKeys(): array
    {
        return [
            self::KEY_ALL_OF,
            self::KEY_ANY_OF,
            self::KEY_ONE_OF
        ];
    }

    /**
     * @return string[]
     */
    public static function getMixedKeys(): array
    {
        return [
            self::KEY_DEFAULT,
            self::KEY_CONST
        ];
    }
}