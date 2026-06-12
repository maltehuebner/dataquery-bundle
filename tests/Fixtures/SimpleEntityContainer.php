<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Fixtures;

class SimpleEntityContainer
{
    public function __construct(
        private readonly ?SimpleEntity $simpleEntity = null
    )
    {

    }

    public function getSimpleEntity(): ?SimpleEntity
    {
        return $this->simpleEntity;
    }
}
