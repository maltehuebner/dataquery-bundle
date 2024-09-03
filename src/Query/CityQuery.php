<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute as DataQuery;
use App\Entity\City;
use Symfony\Component\Validator\Constraints as Constraints;

/**
 * @DataQuery\RequiredEntityProperty(propertyName="slug")
 */
class CityQuery extends AbstractQuery implements DoctrineQueryInterface, ElasticQueryInterface
{
    /**
     * @Constraints\NotNull()
     * @Constraints\Type("App\Entity\City")
     */
    private ?City $city = null;

    /**
     * @DataQuery\RequiredQueryParameter(parameterName="citySlug")
     */
    public function setCity(City $city): CityQuery
    {
        $this->city = $city;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    #[\Override]
    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        return new \Elastica\Query\Term(['city' => $this->city->getCity()]);
    }

    #[\Override]
    public function isOverridenBy(): array
    {
        return [
            RideQuery::class,
        ];
    }
}
