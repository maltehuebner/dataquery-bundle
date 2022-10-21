<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Exception;

class TargetPropertyNotSortableException extends DataQueryException
{
    public function __construct(string $propertyName, string $fqcn)
    {
        $message = sprintf('Method "%s" of class "%s" is not sortable', $propertyName, $fqcn);

        parent::__construct($message);
    }
}