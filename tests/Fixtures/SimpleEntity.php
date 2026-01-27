<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Fixtures;

use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\Queryable;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\Sortable;

class SimpleEntity
{
    #[Queryable]
    #[Sortable]
    private string $name;

    private string $unsortableField;

    public function getName(): string
    {
        return $this->name;
    }
}
