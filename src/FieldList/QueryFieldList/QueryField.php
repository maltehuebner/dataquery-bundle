<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList\QueryFieldList;

use MalteHuebner\DataQueryBundle\FieldList\AbstractField;

class QueryField extends AbstractField
{
    protected ?string $parameterName = null;

    public function getParameterName(): ?string
    {
        return $this->parameterName;
    }

    public function setParameterName(string $parameterName): QueryField
    {
        $this->parameterName = $parameterName;

        return $this;
    }
}
