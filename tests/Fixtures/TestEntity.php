<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Fixtures;

use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\DateTimeQueryable;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\DefaultBooleanValue;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\Queryable;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\Sortable;

class TestEntity
{
    #[Queryable]
    #[Sortable]
    private string $title;

    #[Queryable]
    private string $description;

    #[Sortable]
    private int $position;

    #[DateTimeQueryable(format: 'yyyy-MM-dd', pattern: 'Y-m-d')]
    private \DateTime $dateTime;

    #[DefaultBooleanValue(value: true)]
    private bool $enabled;

    private float $latitude;
    private float $longitude;
    private string $pin;

    #[Queryable]
    #[Sortable]
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
