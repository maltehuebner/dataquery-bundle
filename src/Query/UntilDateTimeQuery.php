<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use Doctrine\ORM\QueryBuilder;
use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute as DataQuery;
use Symfony\Component\Validator\Constraints as Constraints;

#[DataQuery\RequiredEntityProperty(propertyName: 'dateTime', propertyType: 'DateTime')]
class UntilDateTimeQuery extends AbstractDateTimeQuery implements OrmQueryInterface, ElasticQueryInterface
{
    #[Constraints\NotNull]
    #[Constraints\Type('int')]
    private ?int $untilDateTime = null;

    #[DataQuery\RequiredQueryParameter(parameterName: 'untilDateTime')]
    public function setUntilDateTime(int $untilDateTime): UntilDateTimeQuery
    {
        $this->untilDateTime = $untilDateTime;

        return $this;
    }

    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        $dateTimeQuery = new \Elastica\Query\Range($this->propertyName, [
            'lte' => $this->getDateTime()->format($this->dateTimePattern),
            'format' => $this->dateTimeFormat,
        ]);

        return $dateTimeQuery;
    }

    public function createOrmQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $alias = $queryBuilder->getRootAliases()[0];
        $expr = $queryBuilder->expr();

        $queryBuilder
            ->andWhere($expr->lte(
                sprintf('%s.%s', $alias, $this->propertyName),
                ':untilDateTime'
            ))
            ->setParameter('untilDateTime', $this->getDateTime());

        return $queryBuilder;
    }

    protected function getDateTime(): \DateTime
    {
        return new \DateTime(sprintf('@%d', $this->untilDateTime));
    }

    #[\Override]
    public function isOverridenBy(): array
    {
        return [];
    }
}
