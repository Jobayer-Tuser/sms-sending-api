<?php

namespace App\Enums;
use ReflectionClass;
use Log;

abstract class BaseEnum
{
    /**
     * @return array
     */
    public static function getKeys()
    {
        try {
            $class = new ReflectionClass(get_called_class());
        } catch (\ReflectionException $e) {
            Log::error('Enums Reflection Class Error: '. $e->getMessage());
        }
        return array_keys($class->getConstants());
    }
    /**
     * @return array
     */
    public static function getValues()
    {
        try {
            $class = new ReflectionClass(get_called_class());
        } catch (\ReflectionException $e) {
            Log::error('Reflection Class Error: '. $e->getMessage());
        }
        return array_values($class->getConstants());
    }
    /**
     * @return integer
     */
    public static function getKey($value)
    {
        try {
            $class = new ReflectionClass(get_called_class());
            $enum = array_flip($class->getConstants())  ;
            return str_replace('_',' ', $enum[$value]);
        } catch (\ReflectionException $e) {
            Log::error('Reflection Class Error: '. $e->getMessage());
        }
        return null;
    }
}
