<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

interface QueryInterface
{
    public function isOverridenBy(): array;
}
