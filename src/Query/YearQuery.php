<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute as DataQuery;
use App\Criticalmass\Util\DateTimeUtil;
use Symfony\Component\Validator\Constraints as Constraints;

#[DataQuery\RequiredEntityProperty(propertyName: 'dateTime', propertyType: 'DateTime')]
class YearQuery extends AbstractDateTimeQuery implements ElasticQueryInterface, DoctrineQueryInterface
{
    #[Constraints\NotNull]
    #[Constraints\Type('int')]
    #[Constraints\GreaterThanOrEqual(1990)]
    protected ?int $year = null;

    #[DataQuery\RequiredQueryParameter(parameterName: 'year')]
    public function setYear(int $year): YearQuery
    {
        $this->year = $year;

        return $this;
    }

    #[\Override]
    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        $fromDateTime = DateTimeUtil::getYearStartDateTime($this->toDateTime());
        $untilDateTime = DateTimeUtil::getYearEndDateTime($this->toDateTime());

        $dateTimeQuery = new \Elastica\Query\Range($this->propertyName, [
            'gte' => $fromDateTime->format($this->dateTimePattern),
            'lte' => $untilDateTime->format($this->dateTimePattern),
            'format' => $this->dateTimeFormat,
        ]);

        return $dateTimeQuery;
    }

    protected function toDateTime(): \DateTime
    {
        return new \DateTime(sprintf('%d-01-01 00:00:00', $this->year));
    }

    #[\Override]
    public function isOverridenBy(): array
    {
        return [
            MonthQuery::class,
            DateQuery::class,
        ];
    }
}
