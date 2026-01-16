<?php
/*
 * (c) Sqills Products B.V. 2026 <php-dev-enschede@sqills.com>
 */
declare(strict_types=1);

namespace Jojo1981\JsonSchemaAsg\Exception;

use RuntimeException;
use Throwable;

/**
 * @package Jojo1981\JsonSchemaAsg\Exception
 */
final class YamlParseException extends RuntimeException
{
    /** @var int */
    private int $parsedLine;

    /** @var string|null */
    private ?string $snippet;

    /** @var string|null */
    private ?string $parsedFile;

    /**
     * @param string $message
     * @param int $parsedLine
     * @param string|null $snippet
     * @param string|null $parsedFile
     * @param Throwable|null $previous
     */
    public function __construct(string $message, int $parsedLine = -1, ?string $snippet = null, ?string $parsedFile = null, ?Throwable $previous = null)
    {
        $this->parsedLine = $parsedLine;
        $this->snippet = $snippet;
        $this->parsedFile = $parsedFile;
        parent::__construct($message, 0, $previous);
    }

    /**
     * @return int
     */
    public function getParsedLine(): int
    {
        return $this->parsedLine;
    }

    /**
     * @return string|null
     */
    public function getSnippet(): ?string
    {
        return $this->snippet;
    }

    /**
     * @return string|null
     */
    public function getParsedFile(): ?string
    {
        return $this->parsedFile;
    }
}
