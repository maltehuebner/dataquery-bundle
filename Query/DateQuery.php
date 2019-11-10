<?php declare(strict_types=1);

namespace App\Criticalmass\DataQuery\Query;

use App\Criticalmass\Util\DateTimeUtil;
use Elastica\Query\AbstractQuery;

class DateQuery extends MonthQuery
{
    /** @var int $day */
    protected $day;

    public function __construct(int $year, int $month, int $day)
    {
        $this->day = $day;

        parent::__construct($year, $month);
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function createElasticQuery(): AbstractQuery
    {
        $fromDateTime = DateTimeUtil::getDayStartDateTime($this->toDateTime());
        $untilDateTime = DateTimeUtil::getDayEndDateTime($this->toDateTime());

        $dateTimeQuery = new \Elastica\Query\Range('simpleDate', [
            'gte' => $fromDateTime->format('Y-m-d'),
            'lte' => $untilDateTime->format('Y-m-d'),
            'format' => 'yyyy-MM-dd',
        ]);

        return $dateTimeQuery;
    }

    protected function toDateTime(): \DateTime
    {
        return new \DateTime(sprintf('%d-%d-%d 00:00:00', $this->year, $this->month, $this->day));
    }
}
