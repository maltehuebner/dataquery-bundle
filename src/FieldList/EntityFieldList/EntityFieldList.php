<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList\EntityFieldList;

use MalteHuebner\DataQueryBundle\FieldList\AbstractFieldList;

class EntityFieldList extends AbstractFieldList
{
    public function addField(string $fieldName, EntityField $entityProperty): EntityFieldList
    {
        $this->addToList($fieldName, $entityProperty);

        return $this;
    }
}
