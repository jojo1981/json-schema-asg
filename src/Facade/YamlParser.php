<?php
/*
 * (c) Sqills Products B.V. 2026 <php-dev-enschede@sqills.com>
 */
declare(strict_types=1);

namespace Jojo1981\JsonSchemaAsg\Facade;

use Jojo1981\JsonSchemaAsg\Exception\YamlParseException;
use Symfony\Component\Yaml\Exception\ParseException as SymfonyYamlParseException;
use Symfony\Component\Yaml\Yaml as SymfonyYaml;
use TypeError;

/**
 * @package Jojo1981\JsonSchemaAsg\Facade
 * @internal
 */
final class YamlParser
{
    /**
     * Parses YAML into a PHP value.
     *
     * @param string $input
     * @param int $flags
     * @return mixed
     * @throws YamlParseException
     */
    public function parseYaml(string $input, int $flags = 0): mixed
    {
        try {
            return SymfonyYaml::parse($input, $flags);
        } catch (SymfonyYamlParseException $exception) {
            $parsedFile = null;
            try {
                // Hack, because symfony/yaml 7.4.1 returns null instead of a string
                $parsedFile = $exception->getParsedFile();
            } catch (TypeError) {
                // Nothing to do here, just catch the TypeError
            }

            throw new YamlParseException(
                $exception->getMessage(),
                $exception->getParsedLine(),
                $exception->getSnippet(),
                $parsedFile,
                $exception
            );
        }
    }
}
