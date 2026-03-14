<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\PaginatedResult;

class PaginatedResult
{
    public function __construct(
        private readonly iterable $data,
        private readonly int $page,
        private readonly int $size,
        private readonly int $totalItems,
    ) {
    }

    /** @return iterable<object> */
    public function getData(): iterable
    {
        return $this->data;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function getTotalPages(): int
    {
        if ($this->size === 0) {
            return 0;
        }

        return (int) ceil($this->totalItems / $this->size);
    }
}
