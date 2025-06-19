<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Factory\ValueAssigner;

class ValueType
{
    public const STRING = 'string';
    public const INT = 'int';
    public const FLOAT = 'float';
    public const BOOLEAN = 'boolean';
    public const ARRAY = 'array';
    public const OBJECT = 'object';
    public const NULL = 'null';
    public const MIXED = 'mixed';

    private function __construct()
    {

    }
}
