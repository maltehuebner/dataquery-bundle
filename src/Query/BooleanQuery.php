<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Validator\Constraints as Constraints;

class BooleanQuery extends AbstractQuery implements OrmQueryInterface, ElasticQueryInterface
{
    #[Constraints\NotNull]
    #[Constraints\Type("string")]
    protected string $propertyName;

    #[Constraints\NotNull]
    #[Constraints\Type("bool")]
    protected bool $value = false;

    public function setPropertyName(string $propertyName): BooleanQuery
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    public function setValue(bool $value): BooleanQuery
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    #[\Override]
    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        return new \Elastica\Query\Term([$this->propertyName => $this->value]);
    }

    public function createOrmQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $alias = $queryBuilder->getRootAliases()[0];
        $parameterName = $this->propertyName . '_value';

        $queryBuilder
            ->andWhere($queryBuilder->expr()->eq(sprintf('%s.%s', $alias, $this->propertyName), sprintf(':%s', $parameterName)))
            ->setParameter($parameterName, $this->value)
        ;

        return $queryBuilder;
    }
}
