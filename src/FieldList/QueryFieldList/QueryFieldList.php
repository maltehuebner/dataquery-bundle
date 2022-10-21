<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\FieldList\QueryFieldList;

use Maltehuebner\DataQueryBundle\FieldList\AbstractFieldList;

class QueryFieldList extends AbstractFieldList
{
    public function addField(string $fieldName, QueryField $queryField): QueryFieldList
    {
        $this->addToList($fieldName, $queryField);

        return $this;
    }
}
