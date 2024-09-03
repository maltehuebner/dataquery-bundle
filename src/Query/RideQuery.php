<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute as DataQuery;
use App\Entity\Ride;
use Symfony\Component\Validator\Constraints as Constraints;

/**
 * @DataQuery\RequiredEntityProperty(propertyName="slug")
 */
class RideQuery extends AbstractQuery implements DoctrineQueryInterface, ElasticQueryInterface
{
    /**
     * @Constraints\NotNull()
     * @Constraints\Type("App\Entity\Ride")
     */
    private ?Ride $ride = null;

    /**
     * @DataQuery\RequiredQueryParameter(parameterName="rideIdentifier")
     */
    public function setRide(Ride $ride): RideQuery
    {
        $this->ride = $ride;

        return $this;
    }

    public function getRide(): ?Ride
    {
        return $this->ride;
    }

    #[\Override]
    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        return new \Elastica\Query\Term(['rideId' => $this->getRide()->getId()]);
    }
}
