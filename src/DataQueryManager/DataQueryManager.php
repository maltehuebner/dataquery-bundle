<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\DataQueryManager;

use MalteHuebner\DataQueryBundle\Factory\ParameterFactory\ParameterFactoryInterface;
use MalteHuebner\DataQueryBundle\Factory\QueryFactory\QueryFactoryInterface;
use MalteHuebner\DataQueryBundle\FinderFactory\FinderFactoryInterface;
use MalteHuebner\DataQueryBundle\PaginatedResult\PaginatedResult;
use MalteHuebner\DataQueryBundle\Parameter\PageParameter;
use MalteHuebner\DataQueryBundle\Parameter\SizeParameter;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;

class DataQueryManager implements DataQueryManagerInterface
{
    public function __construct(
        private readonly QueryFactoryInterface $queryFactory,
        private readonly ParameterFactoryInterface $parameterFactory,
        private readonly FinderFactoryInterface $finderFactory
    ) {

    }
    
    #[\Override]
    public function query(RequestParameterList $requestParameterList, string $entityFqcn): array
    {
        $queryList = $this->queryFactory->setEntityFqcn($entityFqcn)->createFromList($requestParameterList);
        $parameterList = $this->parameterFactory->setEntityFqcn($entityFqcn)->createFromList($requestParameterList);

        $finder = $this->finderFactory->createFinderForFqcn($entityFqcn);

        return $finder->executeQuery($queryList, $parameterList);
    }

    #[\Override]
    public function paginatedQuery(RequestParameterList $requestParameterList, string $entityFqcn): PaginatedResult
    {
        $queryList = $this->queryFactory->setEntityFqcn($entityFqcn)->createFromList($requestParameterList);
        $parameterList = $this->parameterFactory->setEntityFqcn($entityFqcn)->createFromList($requestParameterList);

        $page = 0;
        $size = 10;

        foreach ($parameterList as $parameter) {
            if ($parameter instanceof PageParameter) {
                $page = $parameter->getPage();
            }

            if ($parameter instanceof SizeParameter) {
                $size = $parameter->getSize();
            }
        }

        $finder = $this->finderFactory->createFinderForFqcn($entityFqcn);

        return $finder->executePaginatedQuery($queryList, $parameterList, $page, $size);
    }
}
