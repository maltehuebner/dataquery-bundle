<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Parameter;

use Maltehuebner\DataQueryBundle\Annotation\ParameterAnnotation as DataQuery;
use Elastica\Query;
use Symfony\Component\Validator\Constraints as Constraints;

class FromParameter extends AbstractParameter
{
    /**
     * @Constraints\NotNull()
     * @Constraints\Type("int")
     * @Constraints\Range(min="0")
     * @var int $from
     */
    protected $from;

    /**
     * @DataQuery\RequiredParameter(parameterName="from")
     */
    public function setFrom(int $from): FromParameter
    {
        $this->from = $from;

        return $this;
    }

    public function addToElasticQuery(Query $query): Query
    {
        return $query->setFrom($this->from);
    }
}
