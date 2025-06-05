<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Parameter;

use Doctrine\ORM\AbstractQuery as AbstractOrmQuery;
use Doctrine\ORM\QueryBuilder;
use Elastica\Query;
use MalteHuebner\DataQueryBundle\Annotation\ParameterAnnotation as DataQuery;
use Symfony\Component\Validator\Constraints as Constraints;

class OrderDistanceParameter extends AbstractParameter
{
    #[Constraints\NotNull]
    #[Constraints\Type('float')]
    private float $latitude;

    #[Constraints\NotNull]
    #[Constraints\Type('float')]
    private float $longitude;

    #[Constraints\NotNull]
    #[Constraints\Type('string')]
    #[Constraints\Choice(choices: ['ASC', 'DESC'])]
    private string $direction;

    /**
     * @DataQuery\RequiredParameter(parameterName="centerLatitude")
     */
    public function setLatitude(float $latitude): OrderDistanceParameter
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @DataQuery\RequiredParameter(parameterName="centerLongitude")
     */
    public function setLongitude(float $longitude): OrderDistanceParameter
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @DataQuery\RequiredParameter(parameterName="distanceOrderDirection")
     */
    public function setDirection(string $direction): OrderDistanceParameter
    {
        $this->direction = strtoupper($direction);
        return $this;
    }

    #[\Override]
    public function addToElasticQuery(Query $query): Query
    {
        $query->addSort([
            '_geo_distance' => [
                'pin' => [
                    $this->longitude,
                    $this->latitude,
                ],
                'order' => $this->direction,
                'unit' => 'km',
                'distance_type' => 'arc',
            ]
        ]);

        return $query;
    }

    #[\Override]
    public function addToOrmQuery(QueryBuilder $queryBuilder): AbstractOrmQuery
    {
        $alias = $queryBuilder->getRootAliases()[0];

        // Haversine-Entfernung als Ausdruck
        $distanceExpr = sprintf(
            '(6371 * 2 * ASIN(SQRT(POWER(SIN((RADIANS(:centerLat - %s.latitude)) / 2), 2) + COS(RADIANS(:centerLat)) * COS(RADIANS(%s.latitude)) * POWER(SIN((RADIANS(:centerLon - %s.longitude)) / 2), 2))))',
            $alias,
            $alias,
            $alias
        );

        $queryBuilder
            ->addSelect($distanceExpr . ' AS HIDDEN distance')
            ->addOrderBy('distance', $this->direction)
            ->setParameter('centerLat', $this->latitude)
            ->setParameter('centerLon', $this->longitude);

        return $queryBuilder->getQuery();
    }
}
