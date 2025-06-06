<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Parameter;

use MalteHuebner\DataQueryBundle\Attribute\ParameterAttribute as DataQuery;
use Doctrine\ORM\AbstractQuery as AbstractOrmQuery;
use Doctrine\ORM\QueryBuilder;
use Elastica\Query;
use Symfony\Component\Validator\Constraints as Constraints;

class StartValueParameter extends OrderParameter
{
    #[Constraints\NotNull]
    private mixed $startValue;

    #[DataQuery\RequiredParameter(parameterName: 'startValue')]
    public function setStartValue(mixed $startValue): StartValueParameter
    {
        $this->startValue = $startValue;

        return $this;
    }

    #[\Override]
    public function addToElasticQuery(Query $query): Query
    {
        $whereClause = [];

        if ($this->direction === 'ASC') {
            $whereClause['gte'] = $this->startValue;
        } else {
            $whereClause['lte'] = $this->startValue;
        }

        $startQuery = new \Elastica\Query\Range($this->propertyName, $whereClause);

        $query->getQuery()->addMust($startQuery);

        return $query;
    }

    #[\Override]
    public function addToOrmQuery(QueryBuilder $queryBuilder): AbstractOrmQuery
    {
        $alias = $queryBuilder->getRootAliases()[0];
        $field = sprintf('%s.%s', $alias, $this->propertyName);

        if ($this->direction === 'ASC') {
            $queryBuilder->andWhere($queryBuilder->expr()->gte($field, ':startValue'));
        } else {
            $queryBuilder->andWhere($queryBuilder->expr()->lte($field, ':startValue'));
        }

        $queryBuilder->setParameter('startValue', $this->startValue);

        return $queryBuilder->getQuery();
    }
}
