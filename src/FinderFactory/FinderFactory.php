<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\FinderFactory;

use Maltehuebner\DataQueryBundle\Finder\Finder;
use Maltehuebner\DataQueryBundle\Finder\FinderInterface;
use FOS\ElasticaBundle\Finder\TransformedFinder;

class FinderFactory implements FinderFactoryInterface
{
    //protected ContainerInterface $container;
    protected TransformedFinder $finder;

    public function __construct(/*ContainerInterface $container, */TransformedFinder $finder)
    {
        //$this->container = $container;
        $this->finder = $finder;
    }

    public function createFinderForFqcn(string $fqcn): FinderInterface
    {
        /*$className = ClassUtil::getLowercaseShortnameFromFqcn($fqcn);

        $schema = 'fos_elastica.finder.criticalmass_%s';

        $finderServiceName = sprintf($schema, $className, $className);

        if ($this->container->has($finderServiceName)) {
            $fosFinder = $this->container->get($finderServiceName);

            return new Finder($fosFinder);
        }

        throw new \Exception(sprintf('Could not find service %s for entity fqcn %s', $finderServiceName, $fqcn));
        */
        return new Finder($this->finder);
    }
}
