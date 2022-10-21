<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\FieldList\ParameterFieldList;

use Maltehuebner\DataQueryBundle\FieldList\AbstractFieldList;

class ParameterFieldList extends AbstractFieldList
{
    public function addField(string $fieldName, ParameterField $parameterField): ParameterFieldList
    {
        $this->addToList($fieldName, $parameterField);

        return $this;
    }
}
