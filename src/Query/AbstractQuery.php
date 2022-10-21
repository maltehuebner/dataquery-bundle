<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Query;

abstract class AbstractQuery implements QueryInterface
{
    public function isOverridenBy(): array
    {
        return [];
    }
}
