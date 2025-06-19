<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FinderFactory;

use MalteHuebner\DataQueryBundle\Finder\Finder;
use MalteHuebner\DataQueryBundle\Finder\FinderInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

class FinderFactory implements FinderFactoryInterface
{
    public function __construct(
        private readonly ServiceLocator $locator
    ) {

    }

    #[\Override]
    public function createFinderForFqcn(string $fqcn): FinderInterface
    {
        $entityManager = $this->locator->has(\Doctrine\ORM\EntityManagerInterface::class)
            ? $this->locator->get(\Doctrine\ORM\EntityManagerInterface::class)
            : null;

        $repositoryManager = $this->locator->has(\FOS\ElasticaBundle\Manager\RepositoryManagerInterface::class)
            ? $this->locator->get(\FOS\ElasticaBundle\Manager\RepositoryManagerInterface::class)
            : null;

        $repository = null;

        if ($repositoryManager !== null) {
            $shortName = (new \ReflectionClass($fqcn))->getShortName();
            $indexName = sprintf('criticalmass_%s', strtolower($shortName));

            if ($repositoryManager->hasRepository($indexName)) {
                $repository = $repositoryManager->getRepository($indexName);
            }
        }

        if ($repository === null && $entityManager === null) {
            throw new \RuntimeException('Weder Doctrine noch Elastica verfügbar.');
        }

        return new Finder($fqcn, $repository, $entityManager);
    }
}
