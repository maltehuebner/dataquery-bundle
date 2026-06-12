<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Fixtures;

use MalteHuebner\DataQueryBundle\Query\AbstractQuery;

class SimpleEntityQuery extends AbstractQuery
{
    private ?SimpleEntity $simpleEntity = null;

    public function setSimpleEntity(SimpleEntity $simpleEntity): self
    {
        $this->simpleEntity = $simpleEntity;

        return $this;
    }

    public function getSimpleEntity(): ?SimpleEntity
    {
        return $this->simpleEntity;
    }
}
