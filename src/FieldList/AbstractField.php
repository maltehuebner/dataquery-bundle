<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList;

abstract class AbstractField
{
    protected ?string $type = null;
    protected ?string $propertyName = null;
    protected ?string $methodName = null;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }

    public function setPropertyName(string $propertyName): self
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    public function getMethodName(): ?string
    {
        return $this->methodName;
    }

    public function setMethodName(string $methodName): self
    {
        $this->methodName = $methodName;

        return $this;
    }
}
