<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use Symfony\Component\Validator\Constraints as Constraints;

class BooleanQuery extends AbstractQuery implements DoctrineQueryInterface, ElasticQueryInterface
{
    /**
     * @Constraints\NotNull()
     * @Constraints\Type("string")
     */
    protected string $propertyName;

    /**
     * @Constraints\NotNull()
     * @Constraints\Type("boolean")
     */
    protected bool $value = false;

    public function setPropertyName(string $propertyName): BooleanQuery
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    public function setValue(bool $value): BooleanQuery
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    #[\Override]
    public function createElasticQuery(): \Elastica\Query\AbstractQuery
    {
        return new \Elastica\Query\Term([$this->propertyName => $this->value]);
    }
}
