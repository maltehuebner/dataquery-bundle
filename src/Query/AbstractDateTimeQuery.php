<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

use Symfony\Component\Validator\Constraints as Constraints;

abstract class AbstractDateTimeQuery extends AbstractQuery implements DateTimeQueryInterface
{
    /**
     * @Constraints\NotNull()
     * @Constraints\Type("string")
     */
    protected string $dateTimePattern;

    /**
     * @Constraints\NotNull()
     * @Constraints\Type("string")
     */
    protected string $dateTimeFormat;

    /**
     * @Constraints\NotNull()
     * @Constraints\Type("string")
     */
    protected string $propertyName;

    #[\Override]
    public function setDateTimePattern(string $dateTimePattern): DateTimeQueryInterface
    {
        $this->dateTimePattern = $dateTimePattern;

        return $this;
    }

    #[\Override]
    public function setDateTimeFormat(string $dateTimeFormat): DateTimeQueryInterface
    {
        $this->dateTimeFormat = $dateTimeFormat;

        return $this;
    }

    #[\Override]
    public function setPropertyName(string $propertyName): DateTimeQueryInterface
    {
        $this->propertyName = $propertyName;

        return $this;
    }
}
