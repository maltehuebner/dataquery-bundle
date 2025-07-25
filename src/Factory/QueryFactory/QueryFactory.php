<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Factory\QueryFactory;

use MalteHuebner\DataQueryBundle\Factory\ConflictResolver\ConflictResolver;
use MalteHuebner\DataQueryBundle\Factory\ValueAssigner\ValueAssignerInterface;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityField;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityFieldListFactoryInterface;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryField;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryFieldListFactoryInterface;
use MalteHuebner\DataQueryBundle\Manager\QueryManagerInterface;
use MalteHuebner\DataQueryBundle\Query\BooleanQuery;
use MalteHuebner\DataQueryBundle\Query\DateTimeQueryInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use App\Criticalmass\Util\ClassUtil;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QueryFactory implements QueryFactoryInterface
{
    private string $entityFqcn;

    public function __construct(
        private readonly QueryManagerInterface $queryManager,
        private readonly ValueAssignerInterface $valueAssigner,
        private readonly ValidatorInterface $validator,
        private readonly EntityFieldListFactoryInterface $entityFieldListFactory,
        private readonly QueryFieldListFactoryInterface $queryFieldListFactory
    ) {

    }

    #[\Override]
    public function setEntityFqcn(string $entityFqcn): QueryFactoryInterface
    {
        $this->entityFqcn = $entityFqcn;

        return $this;
    }

    #[\Override]
    public function createFromList(RequestParameterList $requestParameterList): array
    {
        $queryList = $this->findEntityDefaultValuesAsQuery();

        /** @var QueryInterface $queryCandidate */
        foreach ($this->queryManager->getQueryList() as $queryCandidate) {
            $query = $this->checkForQuery($queryCandidate::class, $requestParameterList);

            if ($query) {
                $queryList[ClassUtil::getShortname($query)] = $query;
            }
        }

        $queryList = ConflictResolver::resolveConflicts($queryList);

        // dump($queryList);

        return $queryList;
    }

    protected function checkForQuery(string $queryFqcn, RequestParameterList $requestParameterList): ?QueryInterface
    {
        $query = new $queryFqcn();
        $query->setEntityFqcn($this->entityFqcn);

        $queryFieldList = $this->queryFieldListFactory->createForFqcn($queryFqcn);
        $entityFieldList = $this->entityFieldListFactory->createForFqcn($this->entityFqcn);

        /**
         * @var string $fieldName
         * @var array $queryFields
         */
        foreach ($queryFieldList->getList() as $fieldName => $queryFields) {
            /** @var QueryField $queryField */
            foreach ($queryFields as $queryField) {
                $this->valueAssigner->assignQueryPropertyValueFromRequest($requestParameterList, $query, $queryField);
            }
        }

        if ($query instanceof DateTimeQueryInterface) {
            /** @var EntityField $entityField */
            foreach ($entityFieldList->getList() as $entityFields) {
                foreach ($entityFields as $entityField) {
                    if ($entityField->getDateTimePattern() && $entityField->getDateTimeFormat()) {
                        $query
                            ->setDateTimePattern($entityField->getDateTimePattern())
                            ->setDateTimeFormat($entityField->getDateTimeFormat())
                            ->setPropertyName($entityField->getPropertyName());

                        break 2;
                    }
                }
            }
        }

        if (!$this->isQueryValid($query)) {
            return null;
        }

        return $query;
    }

    protected function findEntityDefaultValuesAsQuery(): array
    {
        $defaultValueQueryList = [];
        $entityFieldList = $this->entityFieldListFactory->createForFqcn($this->entityFqcn);

        foreach ($entityFieldList->getList() as $entityFieldName => $entityFields) {
            /** @var EntityField $entityField */
            foreach ($entityFields as $entityField) {
                if ($entityField->hasDefaultQueryBool()) {
                    $booleanQuery = new BooleanQuery();
                    $booleanQuery
                        ->setPropertyName($entityField->getPropertyName())
                        ->setValue($entityField->getDefaultQueryBoolValue());

                    $defaultValueQueryList[] = $booleanQuery;
                }
            }
        }

        return $defaultValueQueryList;
    }

    protected function isQueryValid(QueryInterface $query): bool
    {
        /** @var ConstraintViolationListInterface $constraintViolationList */
        $constraintViolationList = $this->validator->validate($query);

        return $constraintViolationList->count() === 0;
    }
}
