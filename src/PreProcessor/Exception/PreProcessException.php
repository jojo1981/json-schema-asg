<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\PreProcessor\Exception;

use Jojo1981\JsonSchemaAsg\Uri\UriInterface;

/**
 * The base class for all exceptions thrown during the preprocess
 *
 * @package Jojo1981\JsonSchemaAsg\PreProcessor\Exception
 */
class PreProcessException extends \RuntimeException
{
    /**
     * @return PreProcessException
     */
    public static function invalidIdValueTypeFound(): PreProcessException
    {
        return new static('Expect value of `$id` to be of type string');
    }

    /**
     * @return PreProcessException
     */
    public static function invalidRefValueTypeFound(): PreProcessException
    {
        return new static('Expect value of `$ref` to be of type string');
    }

    /**
     * @param string $typeFound
     * @return PreProcessException
     */
    public static function invalidSchemaDataFound(string $typeFound): PreProcessException
    {
        return new static(\sprintf(
            'Expect schema data to be of type boolean, array or nested array and not to be of type: %s',
            $typeFound
        ));
    }

    /**
     * @param UriInterface $uri
     * @return PreProcessException
     */
    public static function invalidUriPassed(UriInterface $uri): PreProcessException
    {
        return new static(\sprintf('Expect uri to contain an absolute path. Passed uri: %s', (string) $uri));
    }

    /**
     * @param string $value
     * @return PreProcessException
     */
    public static function invalidRefValueWhichPointToNoExistingIdentifierFound(string $value): PreProcessException
    {
        return new static(\sprintf(
            'Invalid `$ref` value found. Identifier with value: %s not found in schema',
            $value
        ));
    }
}