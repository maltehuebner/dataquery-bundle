<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use Doctrine\ORM\QueryBuilder;
use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute as DataQuery;
use App\Criticalmass\Util\DateTimeUtil;
use Symfony\Component\Validator\Constraints as Constraints;
use Doctrine\ORM\AbstractQuery as AbstractOrmQuery;

#[DataQuery\RequiredEntityProperty(propertyName: 'dateTime', propertyType: 'DateTime')]
class DateQuery extends MonthQuery
{
    #[Constraints\NotNull]
    #[Constraints\Type('int')]
    #[Constraints\Range(min: 1, max: 31)]
    private ?int $day = null;

    #[DataQuery\RequiredQueryParameter(parameterName: 'day')]
    public function setDay(int $day): DateQuery
    {
        $this->day = $day;

        return $this;
    }

    #[\Override]
    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        $fromDateTime = DateTimeUtil::getDayStartDateTime($this->toDateTime());
        $untilDateTime = DateTimeUtil::getDayEndDateTime($this->toDateTime());

        $dateTimeQuery = new \Elastica\Query\Range($this->propertyName, [
            'gte' => $fromDateTime->format($this->dateTimePattern),
            'lte' => $untilDateTime->format($this->dateTimePattern),
            'format' => $this->dateTimeFormat,
        ]);

        return $dateTimeQuery;
    }

    public function createOrmQuery(QueryBuilder $queryBuilder): AbstractOrmQuery
    {
        $alias = $queryBuilder->getRootAliases()[0];
        $expr = $queryBuilder->expr();

        $fromDateTime = DateTimeUtil::getDayStartDateTime($this->toDateTime());
        $untilDateTime = DateTimeUtil::getDayEndDateTime($this->toDateTime());

        $queryBuilder
            ->andWhere($expr->between(
                sprintf('%s.%s', $alias, $this->propertyName),
                ':fromDateTime',
                ':untilDateTime'
            ))
            ->setParameter('fromDateTime', $fromDateTime)
            ->setParameter('untilDateTime', $untilDateTime);

        return $queryBuilder->getQuery();
    }

    #[\Override]
    protected function toDateTime(): \DateTime
    {
        return new \DateTime(sprintf('%d-%d-%d 00:00:00', $this->year, $this->month, $this->day));
    }

    #[\Override]
    public function isOverridenBy(): array
    {
        return [];
    }
}
