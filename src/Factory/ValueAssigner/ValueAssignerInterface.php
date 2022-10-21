<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Factory\ValueAssigner;

use Maltehuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterField;
use Maltehuebner\DataQueryBundle\FieldList\QueryFieldList\QueryField;
use Maltehuebner\DataQueryBundle\Parameter\ParameterInterface;
use Maltehuebner\DataQueryBundle\Query\QueryInterface;
use Maltehuebner\DataQueryBundle\RequestParameterList\RequestParameterList;

interface ValueAssignerInterface
{
    public function assignQueryPropertyValueFromRequest(RequestParameterList $requestParameterList, QueryInterface $query, QueryField $queryField): QueryInterface;

    public function assignParameterPropertyValueFromRequest(RequestParameterList $requestParameterList, ParameterInterface $parameter, ParameterField $parameterField): ParameterInterface;
}