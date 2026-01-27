<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Fixtures;

use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\Queryable;

class TestEntityNoReturnType
{
    #[Queryable]
    public function getTitle()
    {
        return 'test';
    }
}
