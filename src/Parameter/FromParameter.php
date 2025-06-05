<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Parameter;

use MalteHuebner\DataQueryBundle\Attribute\ParameterAttribute as DataQuery;
use Elastica\Query;
use Symfony\Component\Validator\Constraints as Constraints;

class FromParameter extends AbstractParameter
{
    #[Constraints\NotNull]
    #[Constraints\Type('int')]
    #[Constraints\Range(min: 0)]
    private int $from;

    /**
     * @DataQuery\RequiredParameter(parameterName="from")
     */
    public function setFrom(int $from): FromParameter
    {
        $this->from = $from;

        return $this;
    }

    #[\Override]
    public function addToElasticQuery(Query $query): Query
    {
        return $query->setFrom($this->from);
    }
}
