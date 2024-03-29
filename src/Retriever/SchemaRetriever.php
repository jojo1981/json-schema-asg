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

namespace Jojo1981\JsonSchemaAsg\Retriever;

use Exception;
use Jojo1981\JsonSchemaAsg\Retriever\Exception\RetrieverException;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;
use Symfony\Component\Yaml\Yaml;
use function file_get_contents;
use function in_array;
use function json_decode;
use function json_last_error;
use function json_last_error_msg;
use function pathinfo;

/**
 * This schema retriever can handle retrieving schemas on the local filesystem and on the network/internet. Also it can
 * parse json schema content defined in json syntax or yaml syntax. Only file names with the extension .yml or .yaml will
 * be parsed as yaml content
 *
 * @package Jojo1981\JsonSchemaAsg\Retriever
 */
class SchemaRetriever implements SchemaRetrieverInterface
{
    /**
     * @param UriInterface $uri
     * @throws RetrieverException
     * @return bool|array|array[]
     */
    public function readSchemaDataFromUri(UriInterface $uri): array|bool
    {
        $content = $this->getContentFromUri($uri);
        if ($this->shouldParseAsYaml($uri)) {
            return $this->parseYamlContent($uri, $content);
        }

        return $this->parseJsonContent($uri, $content);
    }

    /**
     * @param UriInterface $uri
     * @return string
     * @throws RetrieverException
     */
    private function getContentFromUri(UriInterface $uri): string
    {
        $content = @file_get_contents((string) $uri);
        if (false === $content) {
            throw RetrieverException::notExistingUri($uri);
        }

        return $content;
    }

    /**
     * @param UriInterface $uri
     * @return bool
     */
    private function shouldParseAsYaml(UriInterface $uri): bool
    {
        if ('' !== $uri->getPath()) {
            $extension = pathinfo($uri->getPath(), PATHINFO_EXTENSION);
            return in_array($extension, ['yml', 'yaml']);
        }

        return false;
    }

    /**
     * @param UriInterface $uri
     * @param string $content
     * @throws RetrieverException
     * @return bool|array|array[]
     */
    private function parseYamlContent(UriInterface $uri, string $content): array|bool
    {
        try {
            return Yaml::parse($content);
        } catch (Exception $exception) {
            throw RetrieverException::couldNotParseYamlContent($uri, $exception);
        }
    }

    /**
     * @param UriInterface $uri
     * @param string $content
     * @throws RetrieverException
     * @return null|bool|array|array[]
     */
    private function parseJsonContent(UriInterface $uri, string $content): array|bool|null
    {
        $result = json_decode($content, true);
        if (null === $result && json_last_error() > 0) {
            throw RetrieverException::couldNotParseJsonContent($uri, json_last_error_msg(), json_last_error());
        }

        return $result;
    }
}
