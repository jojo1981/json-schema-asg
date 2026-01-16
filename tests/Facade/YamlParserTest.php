<?php
/*
 * (c) Sqills Products B.V. 2026 <php-dev-enschede@sqills.com>
 */
declare(strict_types=1);

namespace Tests\Jojo1981\JsonSchemaAsg\Facade;

use Jojo1981\JsonSchemaAsg\Exception\YamlParseException;
use Jojo1981\JsonSchemaAsg\Facade\YamlParser;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception as PHPUnitException;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * @package Tests\Jojo1981\JsonSchemaAsg\Facade
 */
final class YamlParserTest extends TestCase
{
    /**
     * @param string $inputData
     * @param mixed $expectedResult
     * @return void
     * @throws PHPUnitException
     * @throws YamlParseException
     * @throws ExpectationFailedException
     */
    #[DataProvider('getTestData')]
    public function testParseYamlReturnsCorrectResult(string $inputData, mixed $expectedResult): void
    {
        $result = (new YamlParser())->parseYaml($inputData);
        self::assertIsArray($result);
        self::assertSame($expectedResult, $result);
    }

    /**
     * @return void
     * @throws ExpectationFailedException
     */
    public function testParseYamlThrowsYamlParseExceptionOnInvalidYaml(): void
    {
        $this->expectException(YamlParseException::class);
        $invalidYaml = "foo: bar\nbaz: [unclosed";
        try {
            (new YamlParser())->parseYaml($invalidYaml);
        } catch (YamlParseException $caughtException) {
            self::assertEquals('Malformed inline YAML string at line 2 (near "baz: [unclosed").', $caughtException->getMessage());
            self::assertEquals(0, $caughtException->getCode());
            self::assertInstanceOf(ParseException::class, $caughtException->getPrevious());
            self::assertEquals(2, $caughtException->getParsedLine());
            self::assertEquals('baz: [unclosed', $caughtException->getSnippet());
            self::assertNull($caughtException->getParsedFile());
            throw $caughtException;
        }
    }

    /**
     * @return array<int, array{0: string, 1: mixed}>
     */
    public static function getTestData(): array
    {
        return [
            ["foo: bar\nbaz: 42", ['foo' => 'bar', 'baz' => 42]],
            ["numbers:\n  - one\n  - two\n  - three", ['numbers' => ['one', 'two', 'three']]],
            ["person:\n  name: Alice\n  age: 30", ['person' => ['name' => 'Alice', 'age' => 30]]],
            ["active: true\ncount: 0", ['active' => true, 'count' => 0]],
            ["nested:\n  child:\n    value: test", ['nested' => ['child' => ['value' => 'test']]]],
            ["empty_list: []", ['empty_list' => []]],
            ["null_value: null", ['null_value' => null]],
        ];
    }
}
