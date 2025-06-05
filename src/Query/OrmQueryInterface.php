<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use \Doctrine\ORM\AbstractQuery as AbstractOrmQuery;
use Doctrine\ORM\QueryBuilder;

interface OrmQueryInterface extends QueryInterface
{
    public function createOrmQuery(QueryBuilder $queryBuilder): AbstractOrmQuery;
}
