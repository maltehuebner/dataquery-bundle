<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use MalteHuebner\DataQueryBundle\Annotation\QueryAnnotation as DataQuery;
use App\Entity\Region;
use Symfony\Component\Validator\Constraints as Constraints;

/**
 * @DataQuery\RequiredEntityProperty(propertyName="region")
 */
class RegionQuery extends AbstractQuery implements DoctrineQueryInterface, ElasticQueryInterface
{
    #[Constraints\NotNull]
    #[Constraints\Type(Region::class)]
    private ?Region $region = null;

    /**
     * @DataQuery\RequiredQueryParameter(parameterName="regionSlug")
     */
    public function setRegion(Region $region): RegionQuery
    {
        $this->region = $region;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    #[\Override]
    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        $regionQuery = new \Elastica\Query\BoolQuery();
        $regionQuery->addShould(new \Elastica\Query\Term(['region' => $this->region->getName()]));
        $regionQuery->addShould(new \Elastica\Query\Term(['country' => $this->region->getName()]));
        $regionQuery->addShould(new \Elastica\Query\Term(['continent' => $this->region->getName()]));

        return $regionQuery;
    }
}
