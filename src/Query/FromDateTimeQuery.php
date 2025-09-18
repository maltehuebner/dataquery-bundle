<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use Doctrine\ORM\QueryBuilder;
use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute as DataQuery;
use Symfony\Component\Validator\Constraints as Constraints;

#[DataQuery\RequiredEntityProperty(propertyName: 'dateTime', propertyType: 'DateTime')]
class FromDateTimeQuery extends AbstractDateTimeQuery implements OrmQueryInterface, ElasticQueryInterface
{
    #[Constraints\NotNull]
    #[Constraints\Type('int')]
    private ?int $fromDateTime = null;

    #[DataQuery\RequiredQueryParameter(parameterName: 'fromDateTime')]
    public function setFromDateTime(int $fromDateTime): FromDateTimeQuery
    {
        $this->fromDateTime = $fromDateTime;

        return $this;
    }

    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        $dateTimeQuery = new \Elastica\Query\Range($this->propertyName, [
            'gte' => $this->getDateTime()->format($this->dateTimePattern),
            'format' => $this->dateTimeFormat,
        ]);

        return $dateTimeQuery;
    }

    public function createOrmQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $alias = $queryBuilder->getRootAliases()[0];
        $expr = $queryBuilder->expr();

        $queryBuilder
            ->andWhere($expr->gte(
                sprintf('%s.%s', $alias, $this->propertyName),
                ':fromDateTime'
            ))
            ->setParameter('fromDateTime', $this->getDateTime());

        return $queryBuilder;
    }

    protected function getDateTime(): \DateTime
    {
        return new \DateTime(sprintf('@%d', $this->fromDateTime));
    }

    #[\Override]
    public function isOverridenBy(): array
    {
        return [];
    }
}
