<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList;

use MalteHuebner\DataQueryBundle\FieldList\AbstractField;

class ParameterField extends AbstractField
{
    private string $parameterName;
    private bool $requiresQueryable = false;
    private string $dateTimeFormat;
    private string $dateTimePattern;

    public function hasParameterName(): bool
    {
        return $this->parameterName !== null;
    }
    
    public function getParameterName(): string
    {
        return $this->parameterName;
    }

    public function setParameterName(string $parameterName): ParameterField
    {
        $this->parameterName = $parameterName;

        return $this;
    }

    public function requiresQueryable(): bool
    {
        return $this->requiresQueryable;
    }

    public function setRequiresQueryable(bool $requiresQueryable): ParameterField
    {
        $this->requiresQueryable = $requiresQueryable;

        return $this;
    }

    public function getDateTimeFormat(): string
    {
        return $this->dateTimeFormat;
    }

    public function setDateTimeFormat(string $dateTimeFormat): ParameterField
    {
        $this->dateTimeFormat = $dateTimeFormat;

        return $this;
    }

    public function getDateTimePattern(): string
    {
        return $this->dateTimePattern;
    }

    public function setDateTimePattern(string $dateTimePattern): ParameterField
    {
        $this->dateTimePattern = $dateTimePattern;

        return $this;
    }
}
