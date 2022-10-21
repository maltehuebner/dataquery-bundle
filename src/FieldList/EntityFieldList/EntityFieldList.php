<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\FieldList\EntityFieldList;

use Maltehuebner\DataQueryBundle\FieldList\AbstractFieldList;

class EntityFieldList extends AbstractFieldList
{
    public function addField(string $fieldName, EntityField $entityProperty): EntityFieldList
    {
        $this->addToList($fieldName, $entityProperty);

        return $this;
    }
}
