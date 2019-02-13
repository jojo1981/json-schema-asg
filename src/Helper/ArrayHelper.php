<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\Helper;

/**
 * @package Jojo1981\JsonSchemaAsg\Helper
 */
final class ArrayHelper
{
    private function __construct()
    {
        // prevent getting an instance of this class
    }

    /**
     * Only true when it's an array an all the keys are strings and at least
     * one key value pair exists. An empty array wil be considered as an empty sequence
     *
     * @param array $data
     * @return bool
     */
    public static function isAssociativeArray($data): bool
    {
        if (!\is_array($data) || (\is_array($data) && empty($data))) {
            return false;
        }

        foreach (\array_keys($data) as $key) {
            if (!\is_string($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Only true when the array is empty or has only integer values as keys
     *
     * @param array $data
     * @return bool
     */
    public static function isSequenceArray($data): bool
    {
        if (!\is_array($data)) {
            return false;
        }

        foreach (\array_keys($data) as $key) {
            if (!\is_int($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $data
     * @param string $type
     * @return bool
     */
    public static function areAllArrayElementsOfType(array $data, string $type): bool
    {
        foreach ($data as $item) {
            if (\gettype($item) !== \strtolower($type)) {
                return false;
            }
        }

        return true;
    }
}