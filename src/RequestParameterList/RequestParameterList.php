<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\RequestParameterList;

class RequestParameterList
{
    private array $list = [];

    public function add(string $key, string $value): RequestParameterList
    {
        $this->list[$key] = $value;

        return $this;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->list);
    }

    public function get(string $key): string
    {
        return $this->list[$key];
    }

    public function getList(): array
    {
        return $this->list;
    }
}
