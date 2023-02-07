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

use Jojo1981\JsonSchemaAsg\Uri\Path;
use LogicException;
use function array_pop;
use function explode;
use function implode;
use function trim;

/**
 * @package Jojo1981\JsonSchemaAsg\Helper
 */
final class PathHelper
{
    /**
     * private constructor to prevent getting an instance of the class
     */
    private function __construct()
    {
        // Nothing to do here
    }

    /**
     * @param string $relativePath
     * @param string $absolutePath
     * @throws LogicException
     * @return string
     */
    public static function getAbsolutePath(string $relativePath, string $absolutePath): string
    {
        $objectRelativePath = new Path($relativePath);
        $objectAbsolutePath = new Path($absolutePath);
        if ($objectRelativePath->isAbsolute()) {
            throw new LogicException('Expect relative path to be relative');
        }
        if (!$objectAbsolutePath->isAbsolute()) {
            throw new LogicException('Expect absolute path to be absolute');
        }

        $result = explode(DIRECTORY_SEPARATOR, trim((string) $objectAbsolutePath, DIRECTORY_SEPARATOR));
        $pathParts = explode(DIRECTORY_SEPARATOR, (string) $objectRelativePath);
        foreach ($pathParts as $pathPart) {
            if ('..' === $pathPart) {
                array_pop($result);
            } elseif ('.' !== $pathPart) {
                $result[] = $pathPart;
            }
        }

        return DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $result);
    }

    /**
     * @param string $path
     * @return bool
     */
    public static function isAbsolute(string $path): bool
    {
        return (new Path($path))->isAbsolute();
    }
}
