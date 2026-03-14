<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Parameter;

use MalteHuebner\DataQueryBundle\Attribute\ParameterAttribute as DataQuery;
use Doctrine\ORM\AbstractQuery as AbstractOrmQuery;
use Doctrine\ORM\QueryBuilder;
use Elastica\Query;
use Symfony\Component\Validator\Constraints as Constraints;

class PageParameter extends AbstractParameter
{
    #[Constraints\NotNull]
    #[Constraints\Type('int')]
    #[Constraints\Range(min: 0)]
    private int $page;

    private int $size = 10;

    #[DataQuery\RequiredParameter(parameterName: 'page')]
    public function setPage(int $page): PageParameter
    {
        $this->page = $page;
        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPageSize(int $size): PageParameter
    {
        $this->size = $size;
        return $this;
    }

    #[\Override]
    public function addToElasticQuery(Query $query): Query
    {
        return $query->setFrom($this->page * $this->size);
    }

    #[\Override]
    public function addToOrmQuery(QueryBuilder $queryBuilder): AbstractOrmQuery
    {
        $queryBuilder->setFirstResult($this->page * $this->size);

        return $queryBuilder->getQuery();
    }
}
