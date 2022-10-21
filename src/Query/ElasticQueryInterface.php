<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Query;

use Elastica\Query\AbstractQuery;

interface ElasticQueryInterface extends QueryInterface
{
    public function createElasticQuery(): AbstractQuery;
}