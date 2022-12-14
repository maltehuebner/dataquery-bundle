<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FinderFactory;

use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use MalteHuebner\DataQueryBundle\Finder\Finder;
use MalteHuebner\DataQueryBundle\Finder\FinderInterface;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FinderFactory implements FinderFactoryInterface
{
    protected ContainerInterface $container;
    protected RepositoryManagerInterface $repositoryManager;

    public function __construct(ContainerInterface $container, RepositoryManagerInterface $repositoryManager)
    {
        $this->repositoryManager = $repositoryManager;
        $this->container = $container;
    }

    public function createFinderForFqcn(string $fqcn): FinderInterface
    {
        $reflectionClass = new \ReflectionClass($fqcn);

        $schema = 'criticalmass_%s';

        $indexName = sprintf($schema, strtolower($reflectionClass->getShortName()));

        if ($this->repositoryManager->hasRepository($indexName)) {
            $repository = $this->repositoryManager->getRepository($indexName);

            return new Finder($repository);
        }

        throw new \Exception(sprintf('Could not find repository for entity "%s", looked for "%s"', $fqcn, $indexName));
    }
}
