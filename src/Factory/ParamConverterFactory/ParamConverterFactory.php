<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Factory\ParamConverterFactory;

use App\Criticalmass\Util\ClassUtil;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Doctrine\Persistence\ManagerRegistry;

class ParamConverterFactory implements ParamConverterFactoryInterface
{
    private const string PARAMCONVERTER_NAMESPACE = 'App\\Request\\ParamConverter\\';
    private const string PARAMCONVERTER_SUFFIX = 'ParamConverter';

    public function __construct(private readonly ManagerRegistry $registry)
    {

    }

    #[\Override]
    public function createParamConverter(string $fqcn): ?ParamConverterInterface
    {
        $entityShortname = ClassUtil::getShortnameFromFqcn($fqcn);
        $paramConverterFqcn = sprintf('%s%s%s', self::PARAMCONVERTER_NAMESPACE, $entityShortname, self::PARAMCONVERTER_SUFFIX);

        if (!class_exists($paramConverterFqcn)) {
            return null;
        }

        return new $paramConverterFqcn($this->registry);
    }
}
