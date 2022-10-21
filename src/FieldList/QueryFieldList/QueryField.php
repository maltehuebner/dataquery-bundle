<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\FieldList\QueryFieldList;

use Maltehuebner\DataQueryBundle\FieldList\AbstractField;

class QueryField extends AbstractField
{
    /** @var string $parameterName */
    protected $parameterName;

    public function getParameterName(): string
    {
        return $this->parameterName;
    }

    public function setParameterName(string $parameterName): QueryField
    {
        $this->parameterName = $parameterName;

        return $this;
    }
}
