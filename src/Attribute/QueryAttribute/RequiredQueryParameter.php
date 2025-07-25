<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Attribute\QueryAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AbstractAttribute;

#[\Attribute]
class RequiredQueryParameter extends AbstractAttribute implements QueryAttributeInterface
{
    public function __construct(
        private readonly string $parameterName,
        private readonly ?string $repository = null,
        private readonly ?string $repositoryMethod = null,
        private readonly ?string $accessor = null,
    ) {}

    public function getParameterName(): string
    {
        return $this->parameterName;
    }

    public function getRepository(): ?string
    {
        return $this->repository;
    }

    public function getRepositoryMethod(): ?string
    {
        return $this->repositoryMethod;
    }

    public function getAccessor(): ?string
    {
        return $this->accessor;
    }
}
