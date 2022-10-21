<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Exception;

class MissingMethodParameterException extends DataQueryException
{
    public function __construct(string $methodName, string $fqcn)
    {
        $message = sprintf('Method "%s" of class "%s" has no parameters', $methodName, $fqcn);

        parent::__construct($message);
    }
}