<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Attribute\EntityAttribute;

class DateTimeQueryable extends Queryable implements EntityAttributeInterface
{
    public function __construct(
        private readonly array $accepts = [],
        private readonly ?string $format = null,
        private readonly ?string $pattern = null)
    {

    }

    public function getAccepts(): array
    {
        return $this->accepts;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }
}
