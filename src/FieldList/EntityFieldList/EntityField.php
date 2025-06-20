<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList\EntityFieldList;

use MalteHuebner\DataQueryBundle\FieldList\AbstractField;

class EntityField extends AbstractField
{
    private bool $queryable = false;

    private bool $sortable = false;

    private bool $defaultQueryBoolValue = false;

    private bool $defaultQueryBool = false;

    private ?string $dateTimeFormat = null;

    private ?string $dateTimePattern = null;

    public function isQueryable(): bool
    {
        return $this->queryable;
    }

    public function setQueryable(bool $queryable): EntityField
    {
        $this->queryable = $queryable;

        return $this;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function setSortable(bool $sortable): EntityField
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function hasDefaultQueryBool(): bool
    {
        return $this->defaultQueryBool;
    }

    public function setDefaultQueryBool(bool $defaultQueryBool): EntityField
    {
        $this->defaultQueryBool = $defaultQueryBool;

        return $this;
    }

    public function getDefaultQueryBoolValue(): bool
    {
        return $this->defaultQueryBoolValue;
    }

    public function setDefaultQueryBoolValue(bool $defaultQueryBoolValue): EntityField
    {
        $this->defaultQueryBoolValue = $defaultQueryBoolValue;

        return $this;
    }

    public function getDateTimeFormat(): ?string
    {
        return $this->dateTimeFormat;
    }

    public function setDateTimeFormat(string $dateTimeFormat): EntityField
    {
        $this->dateTimeFormat = $dateTimeFormat;

        return $this;
    }

    public function getDateTimePattern(): ?string
    {
        return $this->dateTimePattern;
    }

    public function setDateTimePattern(string $dateTimePattern): EntityField
    {
        $this->dateTimePattern = $dateTimePattern;

        return $this;
    }
}
