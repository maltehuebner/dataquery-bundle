<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use Doctrine\ORM\QueryBuilder;
use MalteHuebner\DataQueryBundle\Annotation\QueryAnnotation as DataQuery;
use App\Criticalmass\Util\DateTimeUtil;
use Symfony\Component\Validator\Constraints as Constraints;
use Doctrine\ORM\AbstractQuery as AbstractOrmQuery;

/**
 * @DataQuery\RequiredEntityProperty(propertyName="dateTime", propertyType="DateTime")
 */
class MonthQuery extends YearQuery
{
    #[Constraints\NotNull]
    #[Constraints\Type("int")]
    #[Constraints\Range(min: 1, max: 12)]
    protected ?int $month = null;
    
    /**
     * @DataQuery\RequiredQueryParameter(parameterName="month")
     */
    public function setMonth(int $month): MonthQuery
    {
        $this->month = $month;

        return $this;
    }

    #[\Override]
    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        $fromDateTime = DateTimeUtil::getMonthStartDateTime($this->toDateTime());
        $untilDateTime = DateTimeUtil::getMonthEndDateTime($this->toDateTime());

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

        $fromDateTime = DateTimeUtil::getMonthStartDateTime($this->toDateTime());
        $untilDateTime = DateTimeUtil::getMonthEndDateTime($this->toDateTime());

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
        return new \DateTime(sprintf('%d-%d-01 00:00:00', $this->year, $this->month));
    }

    #[\Override]
    public function isOverridenBy(): array
    {
        return [DateQuery::class];
    }
}
