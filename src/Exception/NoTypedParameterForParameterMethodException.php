<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Exception;

class NoTypedParameterForParameterMethodException extends DataQueryException
{
    public function __construct(string $methodName, string $fqcn)
    {
        $message = sprintf('Method "%s" of class "%s" has no typed parameter', $methodName, $fqcn);

        parent::__construct($message);
    }
}