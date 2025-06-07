<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Parameter;

use Doctrine\ORM\QueryBuilder;
use Elastica\Query;
use \Doctrine\ORM\AbstractQuery as AbstractOrmQuery;

interface ParameterInterface
{
    public function setEntityFqcn(string $entityFqcn): ParameterInterface;

    public function getEntityFqcn(): string;
    
    public function addToElasticQuery(Query $query): Query;
    public function addToOrmQuery(QueryBuilder $queryBuilder): AbstractOrmQuery;
}