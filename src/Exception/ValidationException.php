<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Exception;

class ValidationException extends DataQueryException
{
    public function __construct(string $errorMessage)
    {
        $message = sprintf('Could not validate query: "%s"', $errorMessage);

        parent::__construct($message);
    }
}
