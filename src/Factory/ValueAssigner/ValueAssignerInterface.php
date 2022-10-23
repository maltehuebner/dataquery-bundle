<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Factory\ValueAssigner;

use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterField;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryField;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;

interface ValueAssignerInterface
{
    public function assignQueryPropertyValueFromRequest(RequestParameterList $requestParameterList, QueryInterface $query, QueryField $queryField): QueryInterface;

    public function assignParameterPropertyValueFromRequest(RequestParameterList $requestParameterList, ParameterInterface $parameter, ParameterField $parameterField): ParameterInterface;
}