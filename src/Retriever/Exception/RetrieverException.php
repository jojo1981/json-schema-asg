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

namespace Jojo1981\JsonSchemaAsg\Retriever\Exception;

use Exception;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;
use RuntimeException;
use function sprintf;

/**
 * This is the base class for all exceptions thrown during the retrieval and parse process of json schema data
 *
 * @package Jojo1981\JsonSchemaAsg\Retriever\Exception
 */
class RetrieverException extends RuntimeException
{
    /**
     * @param UriInterface $uri
     * @return RetrieverException
     */
    public static function notExistingUri(UriInterface $uri): RetrieverException
    {
        return new self(sprintf('Could not get data from uri: %s', $uri));
    }

    /**
     * @param UriInterface $uri
     * @param Exception $previous
     * @return RetrieverException
     */
    public static function couldNotParseYamlContent(UriInterface $uri, Exception $previous): RetrieverException
    {
        return new self(sprintf('Could not parse yaml content for uri: %s', $uri), 0, $previous);
    }

    /**
     * @param UriInterface $uri
     * @param string $errorMessage
     * @param int $jsonErrorCode
     * @return RetrieverException
     */
    public static function couldNotParseJsonContent(
        UriInterface $uri,
        string $errorMessage,
        int $jsonErrorCode
    ): RetrieverException
    {
        return new self(
            sprintf(
                'Could not parse json content for uri: `%s`. Parse error: `%s`[%d] given',
                $uri,
                $errorMessage,
                $jsonErrorCode
            ),
            $jsonErrorCode
        );
    }
}
