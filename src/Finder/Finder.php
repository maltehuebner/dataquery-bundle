<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Finder;

use Doctrine\ORM\EntityManagerInterface;
use FOS\ElasticaBundle\Repository;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use MalteHuebner\DataQueryBundle\Query\ElasticQueryInterface;
use MalteHuebner\DataQueryBundle\Query\OrmQueryInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;

class Finder implements FinderInterface
{
    public function __construct(
        private readonly string $fqcn,
        private readonly Repository $repository,
        private readonly EntityManagerInterface $entityManager
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
            ->from($this->fqcn, 'e');

        /** @var OrmQueryInterface $query */
        foreach ($queryList as $query) {
            if ($query instanceof OrmQueryInterface && method_exists($query, 'setQueryBuilder')) {
                $query->setQueryBuilder($qb);
                $query->createOrmQuery();
            }
        }

        /** @var ParameterInterface $parameter */
        foreach ($parameterList as $parameter) {
            if ($parameter instanceof ParameterInterface && method_exists($parameter, 'addToOrmQuery')) {
                $qb = $parameter->addToOrmQuery($qb);
            }
        }

        return $qb->getQuery()->getResult();
    }

}
