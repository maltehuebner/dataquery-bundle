<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Parameter;

use MalteHuebner\DataQueryBundle\Attribute\ParameterAttribute as DataQuery;
use Doctrine\ORM\AbstractQuery as AbstractOrmQuery;
use Doctrine\ORM\QueryBuilder;
use Elastica\Query;
use Symfony\Component\Validator\Constraints as Constraints;

class SizeParameter extends AbstractParameter
{
    #[Constraints\NotNull]
    #[Constraints\Type('int')]
    #[Constraints\Range(min: 1, max: 500)]
    protected int $size;

    #[DataQuery\RequiredParameter(parameterName: 'size')]
    public function setSize(int $size): SizeParameter
    {
        $this->size = $size;

        return $this;
    }

    #[\Override]
    public function addToElasticQuery(Query $query): Query
    {
        return $query->setSize($this->size);
    }

    #[\Override]
    public function addToOrmQuery(QueryBuilder $queryBuilder): AbstractOrmQuery
    {
        $queryBuilder->setMaxResults($this->size);

        return $queryBuilder->getQuery();
    }
}
