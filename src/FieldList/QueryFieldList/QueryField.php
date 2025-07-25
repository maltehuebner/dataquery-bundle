<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList\QueryFieldList;

use MalteHuebner\DataQueryBundle\FieldList\AbstractField;

class QueryField extends AbstractField
{
    protected ?string $parameterName = null;
    protected ?string $repository = null;
    protected ?string $repositoryMethod = null;
    protected ?string $accessor = null;

    public function getParameterName(): ?string
    {
        return $this->parameterName;
    }

    public function setParameterName(string $parameterName): self
    {
        $this->parameterName = $parameterName;

        return $this;
    }

    public function getRepository(): ?string
    {
        return $this->repository;
    }

    public function setRepository(?string $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function getRepositoryMethod(): ?string
    {
        return $this->repositoryMethod;
    }

    public function setRepositoryMethod(?string $repositoryMethod): self
    {
        $this->repositoryMethod = $repositoryMethod;

        return $this;
    }

    public function getAccessor(): ?string
    {
        return $this->accessor;
    }

    public function setAccessor(?string $accessor): self
    {
        $this->accessor = $accessor;

        return $this;
    }
}
