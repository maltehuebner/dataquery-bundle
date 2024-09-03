<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Parameter;

use MalteHuebner\DataQueryBundle\Attribute\ParameterAttribute as DataQuery;
use MalteHuebner\DataQueryBundle\Validator\Constraint\Sortable;
use Elastica\Query;
use Symfony\Component\Validator\Constraints as Constraints;

class OrderParameter extends AbstractParameter implements PropertyTargetingParameterInterface
{
    /**
     * @Constraints\NotNull()
     * @Constraints\Type("string")
     * @Sortable
     */
    private string $propertyName;

    /**
     * @Constraints\NotNull()
     * @Constraints\Type("string")
     * @Constraints\Choice(choices = {"ASC", "DESC"})
     */
    protected string $direction;

    /**
     * @DataQuery\RequiredParameter(parameterName="orderBy")
     */
    public function setPropertyName(string $propertyName): OrderParameter
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    #[\Override]
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @DataQuery\RequiredParameter(parameterName="orderDirection")
     */
    public function setDirection(string $direction): OrderParameter
    {
        $this->direction = strtoupper($direction);

        return $this;
    }

    #[\Override]
    public function addToElasticQuery(Query $query): Query
    {
        return $query->addSort([$this->propertyName => ['order' => $this->direction]]);
    }
}
