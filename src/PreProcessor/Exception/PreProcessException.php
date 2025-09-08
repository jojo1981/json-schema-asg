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

namespace Jojo1981\JsonSchemaAsg\PreProcessor\Exception;

use Exception;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;
use RuntimeException;
use function sprintf;

/**
 * The base class for all exceptions thrown during the pre-process
 *
 * @package Jojo1981\JsonSchemaAsg\PreProcessor\Exception
 */
class PreProcessException extends RuntimeException
{
    /**
     * @return PreProcessException
     */
    public static function invalidIdValueTypeFound(): PreProcessException
    {
        return new self('Expect value of `$id` to be of type string');
    }

    /**
     * @return PreProcessException
     */
    public static function invalidRefValueTypeFound(): PreProcessException
    {
        return new self('Expect value of `$ref` to be of type string');
    }

    /**
     * @param string $filename
     * @param string $referenceValue
     * @param null|Exception $previous
     * @return PreProcessException
     */
    public static function invalidRefValueFound(
        string $filename,
        string $referenceValue,
        ?Exception $previous = null
    ): PreProcessException
    {
        $message = sprintf('Invalid reference value: `%s` of `$ref` in file: `%s`.', $referenceValue, $filename);
        if (null !== $previous) {
            $message .= PHP_EOL . $previous->getMessage();
        }

        return new self($message, 0, $previous);
    }

    /**
     * @param UriInterface $uri
     * @return PreProcessException
     */
    public static function invalidUriPassed(UriInterface $uri): PreProcessException
    {
        return new self(sprintf('Expect uri to contain an absolute path. Passed uri: %s', $uri));
    }

    /**
     * @param string $value
     * @return PreProcessException
     */
    public static function invalidRefValueWhichPointToNoExistingIdentifierFound(string $value): PreProcessException
    {
        return new self(sprintf(
            'Invalid `$ref` value found. Identifier with value: %s not found in schema',
            $value
        ));
    }
}
