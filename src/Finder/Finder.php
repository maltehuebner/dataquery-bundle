<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Finder;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use FOS\ElasticaBundle\Repository;
use MalteHuebner\DataQueryBundle\PaginatedResult\PaginatedResult;
use MalteHuebner\DataQueryBundle\Parameter\FromParameter;
use MalteHuebner\DataQueryBundle\Parameter\PageParameter;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use MalteHuebner\DataQueryBundle\Parameter\SizeParameter;
use MalteHuebner\DataQueryBundle\Query\ElasticQueryInterface;
use MalteHuebner\DataQueryBundle\Query\OrmQueryInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;

class Finder implements FinderInterface
{
    public function __construct(
        private readonly string $fqcn,
        private readonly ?Repository $repository = null,
        private readonly ?EntityManagerInterface $entityManager = null
    ) {

    }

    #[\Override]
    public function executeQuery(array $queryList, array $parameterList): array
    {
        if ($this->entityManager) {
            return $this->executeOrmQuery($queryList, $parameterList);
        }

        if ($this->repository) {
            return $this->executeElasticQuery($queryList, $parameterList);
        }

        return [];
    }

    protected function executeElasticQuery(array $queryList, array $parameterList): array
    {
        $boolQuery = new \Elastica\Query\BoolQuery();

        /** @var ElasticQueryInterface $query */
        foreach ($queryList as $query) {
            if ($query instanceof QueryInterface) {
                $boolQuery->addMust($query->createElasticQuery());
            }
        }

        $query = new \Elastica\Query($boolQuery);

        /** @var ParameterInterface $parameter */
        foreach ($parameterList as $parameter) {
            if ($parameter instanceof ParameterInterface) {
                $query = $parameter->addToElasticQuery($query);
            }
        }

        return $this->repository->find($query);
    }

    protected function executeOrmQuery(array $queryList, array $parameterList): array
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select('e')
            ->from($this->fqcn, 'e')
        ;

        /** @var OrmQueryInterface $query */
        foreach ($queryList as $query) {
            if ($query instanceof OrmQueryInterface) {
                $qb = $query->createOrmQuery($qb);
            }
        }

        $hasSizeParameter = false;
        $finalQuery = null;

        /** @var ParameterInterface $parameter */
        foreach ($parameterList as $parameter) {
            if ($parameter instanceof SizeParameter) {
                $hasSizeParameter = true;
            }

            if ($parameter instanceof ParameterInterface && method_exists($parameter, 'addToOrmQuery')) {
                $result = $parameter->addToOrmQuery($qb);

                if ($result instanceof AbstractOrmQuery) {
                    $finalQuery = $result;
                }
            }
        }

        // by default, ElasticSearch returns 10 results, but in ORM we set the max results to 10
        if (!$hasSizeParameter) {
            $qb->setMaxResults(10);
        }

        return $qb->getQuery()->getResult();
    }

    #[\Override]
    public function executePaginatedQuery(array $queryList, array $parameterList, int $page, int $size): PaginatedResult
    {
        if ($this->entityManager) {
            return $this->executePaginatedOrmQuery($queryList, $parameterList, $page, $size);
        }

        if ($this->repository) {
            return $this->executePaginatedElasticQuery($queryList, $parameterList, $page, $size);
        }

        return new PaginatedResult([], $page, $size, 0);
    }

    protected function executePaginatedElasticQuery(array $queryList, array $parameterList, int $page, int $size): PaginatedResult
    {
        $boolQuery = new \Elastica\Query\BoolQuery();

        /** @var ElasticQueryInterface $query */
        foreach ($queryList as $query) {
            if ($query instanceof QueryInterface) {
                $boolQuery->addMust($query->createElasticQuery());
            }
        }

        $query = new \Elastica\Query($boolQuery);
        $query->setFrom($page * $size);
        $query->setSize($size);

        /** @var ParameterInterface $parameter */
        foreach ($parameterList as $parameter) {
            if ($parameter instanceof ParameterInterface) {
                $query = $parameter->addToElasticQuery($query);
            }
        }

        $paginatorAdapter = $this->repository->createPaginatorAdapter($query);
        $totalItems = $paginatorAdapter->getNbResults();
        $results = $paginatorAdapter->getSlice(0, $size)->toArray();

        return new PaginatedResult($results, $page, $size, $totalItems);
    }

    protected function executePaginatedOrmQuery(array $queryList, array $parameterList, int $page, int $size): PaginatedResult
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select('e')
            ->from($this->fqcn, 'e')
        ;

        /** @var OrmQueryInterface $query */
        foreach ($queryList as $query) {
            if ($query instanceof OrmQueryInterface) {
                $qb = $query->createOrmQuery($qb);
            }
        }

        /** @var ParameterInterface $parameter */
        foreach ($parameterList as $parameter) {
            if ($parameter instanceof SizeParameter || $parameter instanceof FromParameter || $parameter instanceof PageParameter) {
                continue;
            }

            if ($parameter instanceof ParameterInterface && method_exists($parameter, 'addToOrmQuery')) {
                $parameter->addToOrmQuery($qb);
            }
        }

        $qb->setFirstResult($page * $size);
        $qb->setMaxResults($size);

        $paginator = new Paginator($qb->getQuery());
        $totalItems = count($paginator);
        $data = iterator_to_array($paginator);

        return new PaginatedResult($data, $page, $size, $totalItems);
    }
}
