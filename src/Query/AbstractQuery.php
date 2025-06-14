<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

abstract class AbstractQuery implements QueryInterface
{
    #[\Override]
    public function isOverridenBy(): array
    {
        return [];
    }
}
