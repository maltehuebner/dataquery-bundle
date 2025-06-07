<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use Doctrine\ORM\QueryBuilder;
use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute as DataQuery;
use Symfony\Component\Validator\Constraints as Constraints;

#[DataQuery\RequiredEntityProperty(propertyName: 'pin', propertyType: 'string')]
class RadiusQuery extends AbstractQuery implements ElasticQueryInterface, OrmQueryInterface
{
    #[Constraints\NotNull]
    #[Constraints\Type('float')]
    #[Constraints\Range(min: -90, max: 90)]
    private ?float $centerLatitude = null;

    #[Constraints\NotNull]
    #[Constraints\Type('float')]
    #[Constraints\Range(min: -180, max: 180)]
    private ?float $centerLongitude = null;

    #[Constraints\NotNull]
    #[Constraints\Type('float')]
    #[Constraints\Range(min: 0, max: 50000)]
    private ?float $radius = null;

    #[DataQuery\RequiredQueryParameter(parameterName: 'centerLatitude')]
    public function setCenterLatitude(float $centerLatitude): RadiusQuery
    {
        $this->centerLatitude = $centerLatitude;

        return $this;
    }

    #[DataQuery\RequiredQueryParameter(parameterName: 'centerLongitude')]
    public function setCenterLongitude(float $centerLongitude): RadiusQuery
    {
        $this->centerLongitude = $centerLongitude;

        return $this;
    }

    #[DataQuery\RequiredQueryParameter(parameterName: 'radius')]
    public function setRadius(float $radius): RadiusQuery
    {
        $this->radius = $radius;

        return $this;
    }

    #[\Override]
    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        $kmDistance = sprintf('%dkm', $this->radius);

        $geoQuery = new \Elastica\Query\GeoDistance('pin', [
            'lat' => $this->centerLatitude,
            'lon' => $this->centerLongitude,
        ], $kmDistance);

        return $geoQuery;
    }

    public function createOrmQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $alias = $queryBuilder->getRootAliases()[0];

        $lat = $this->centerLatitude;
        $lon = $this->centerLongitude;
        $radius = $this->radius;

        $haversineFormula = sprintf(
            '(6371 * 2 * ASIN(SQRT(POWER(SIN((RADIANS(:centerLat - %s.latitude)) / 2), 2) + COS(RADIANS(:centerLat)) * COS(RADIANS(%s.latitude)) * POWER(SIN((RADIANS(:centerLon - %s.longitude)) / 2), 2)))) <= :radiusKm',
            $alias, $alias, $alias
        );

        $queryBuilder
            ->andWhere($haversineFormula)
            ->setParameter('centerLat', $lat)
            ->setParameter('centerLon', $lon)
            ->setParameter('radiusKm', $radius)
        ;

        return $queryBuilder;
    }
}
