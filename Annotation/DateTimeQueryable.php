<?php declare(strict_types=1);

namespace App\Criticalmass\DataQuery\Annotation;

/**
 * @Annotation
 */
class DateTimeQueryable extends Queryable
{
    /** @var array $accepts */
    protected $accepts = [];

    /** @var string $format */
    protected $format;

    /** @var string $pattern */
    protected $pattern;

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
