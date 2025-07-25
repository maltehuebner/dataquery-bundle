<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Factory\ConflictResolver;

use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use App\Criticalmass\Util\ClassUtil;

class ConflictResolver
{
    private function __construct()
    {

    }

    public static function resolveConflicts(array $queryList): array
    {
        /** @var QueryInterface $query */
        foreach ($queryList as $queryName => $query) {
            foreach ($query->isOverridenBy() as $overridingQueryFqcn) {
                $overridingQueryName = ClassUtil::getShortnameFromFqcn($overridingQueryFqcn);

                if (array_key_exists($overridingQueryName, $queryList)) {
                    unset($queryList[$queryName]);
                }
            }
        }

        return $queryList;
    }
}
