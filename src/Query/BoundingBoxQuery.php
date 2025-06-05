<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute as DataQuery;
use MalteHuebner\DataQueryBundle\Validator\Constraint\BoundingBoxValues;
use Symfony\Component\Validator\Constraints as Constraints;

/**
 * @DataQuery\RequiredEntityProperty(propertyName="pin", propertyType="string")
 * @BoundingBoxValues()
 */
class BoundingBoxQuery extends AbstractQuery implements ElasticQueryInterface
{
    #[Constraints\NotNull]
    #[Constraints\Type("float")]
    #[Constraints\Range(min:-90, max:90)]
    private ?float $northLatitude = null;

    #[Constraints\NotNull]
    #[Constraints\Type("float")]
    #[Constraints\Range(min:-90, max:90)]
    private ?float $southLatitude = null;

    #[Constraints\NotNull]
    #[Constraints\Type("float")]
    #[Constraints\Range(min:-180, max:180)]
    private ?float $eastLongitude = null;

    #[Constraints\NotNull]
    #[Constraints\Type("float")]
    #[Constraints\Range(min:-180, max:180)]
    private ?float $westLongitude = null;

    /**
     * @DataQuery\RequiredQueryParameter(parameterName="bbNorthLatitude")
     */
    public function setNorthLatitude(float $northLatitude): BoundingBoxQuery
    {
        $this->northLatitude = $northLatitude;

        return $this;
    }

    /**
     * @DataQuery\RequiredQueryParameter(parameterName="bbSouthLatitude")
     */
    public function setSouthLatitude(float $southLatitude): BoundingBoxQuery
    {
        $this->southLatitude = $southLatitude;

        return $this;
    }

    /**
     * @DataQuery\RequiredQueryParameter(parameterName="bbEastLongitude")
     */
    public function setEastLongitude(float $eastLongitude): BoundingBoxQuery
    {
        $this->eastLongitude = $eastLongitude;

        return $this;
    }

    /**
     * @DataQuery\RequiredQueryParameter(parameterName="bbWestLongitude")
     */
    public function setWestLongitude(float $westLongitude): BoundingBoxQuery
    {
        $this->westLongitude = $westLongitude;

        return $this;
    }

    public function getNorthLatitude(): float
    {
        return $this->northLatitude;
    }

    public function getSouthLatitude(): float
    {
        return $this->southLatitude;
    }

    public function getEastLongitude(): float
    {
        return $this->eastLongitude;
    }

    public function getWestLongitude(): float
    {
        return $this->westLongitude;
    }

    public function hasNorthLatitude(): bool
    {
        return $this->northLatitude !== null;
    }

    public function hasSouthLatitude(): bool
    {
        return $this->southLatitude !== null;
    }

    public function hasEastLongitude(): bool
    {
        return $this->eastLongitude !== null;
    }

    public function hasWestLongitude(): bool
    {
        return $this->westLongitude !== null;
    }

    #[\Override]
    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        $geoQuery = new \Elastica\Query\GeoBoundingBox('pin',
            [
                [$this->westLongitude, $this->northLatitude,],
                [$this->eastLongitude, $this->southLatitude,],
            ]);

        return $geoQuery;
    }
}
