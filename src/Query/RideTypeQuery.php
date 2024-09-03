<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use MalteHuebner\DataQueryBundle\Annotation\QueryAnnotation as DataQuery;
use Symfony\Component\Validator\Constraints as Constraints;

/**
 * @DataQuery\RequiredEntityProperty(propertyName="rideType")
 */
class RideTypeQuery extends AbstractQuery implements DoctrineQueryInterface, ElasticQueryInterface
{
    /**
     * @Constraints\NotNull()
     */
    private ?string $rideType = null;

    /**
     * @DataQuery\RequiredQueryParameter(parameterName="rideType")
     */
    public function setRideType(string $rideType): self
    {
        $this->rideType = $rideType;

        return $this;
    }

    public function getRideType(): ?string
    {
        return $this->rideType;
    }

    #[\Override]
    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        return new \Elastica\Query\Term(['rideType' => strtoupper($this->rideType)]);
    }
}
