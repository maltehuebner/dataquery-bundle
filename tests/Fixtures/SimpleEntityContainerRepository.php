<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Fixtures;

use Doctrine\Persistence\ObjectRepository;

/**
 * @implements ObjectRepository<SimpleEntityContainer>
 */
class SimpleEntityContainerRepository implements ObjectRepository
{
    public function __construct(
        private readonly ?SimpleEntityContainer $simpleEntityContainer = null
    )
    {

    }

    public function findOneBySlug(string $slug): ?SimpleEntityContainer
    {
        return $this->simpleEntityContainer;
    }

    public function find(mixed $id): ?object
    {
        return null;
    }

    public function findAll(): array
    {
        return [];
    }

    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
    {
        return [];
    }

    public function findOneBy(array $criteria): ?object
    {
        return null;
    }

    public function getClassName(): string
    {
        return SimpleEntityContainer::class;
    }
}
