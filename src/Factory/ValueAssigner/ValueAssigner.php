<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Factory\ValueAssigner;

use MalteHuebner\DataQueryBundle\Factory\ParamConverterFactory\ParamConverterFactoryInterface;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterField;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryField;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use App\Criticalmass\Util\ClassUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ValueAssigner implements ValueAssignerInterface
{
    public function __construct(private readonly ParamConverterFactoryInterface $paramConverterFactory)
    {

    }

    #[\Override]
    public function assignQueryPropertyValueFromRequest(RequestParameterList $requestParameterList, QueryInterface $query, QueryField $queryField): QueryInterface
    {
        if (!$requestParameterList->has($queryField->getParameterName())) {
            return $query;
        }

        $methodName = $queryField->getMethodName();
        $value = $requestParameterList->get($queryField->getParameterName());
        $type = $queryField->getType();

        switch ($type) {
            case 'float':
                $query->$methodName((float)$value);
                break;

            case 'int':
                $value = $this->convertToInt($value, $queryField->getParameterName());
                $query->$methodName($value);
                break;

            case 'string':
                $query->$methodName((string)$value);
                break;

            case 'mixed':
                $query->$methodName($value);
                break;

            default:
                $query = $this->assignEntityValueFromParamConverter($requestParameterList, $query, $queryField);
                break;
        }

        return $query;
    }

    #[\Override]
    public function assignParameterPropertyValueFromRequest(RequestParameterList $requestParameterList, ParameterInterface $parameter, ParameterField $parameterField): ParameterInterface
    {
        if (!$parameterField->hasParameterName() || !$requestParameterList->has($parameterField->getParameterName())) {
            return $parameter;
        }

        $methodName = $parameterField->getMethodName();
        $value = $requestParameterList->get($parameterField->getParameterName());
        $type = $parameterField->getType();

        switch ($type) {
            case 'float':
                $parameter->$methodName((float)$value);
                break;

            case 'int':
                $value = $this->convertToInt($value, $parameterField->getParameterName());
                $parameter->$methodName($value);
                break;

            case 'string':
                $parameter->$methodName((string)$value);
                break;

            case 'mixed':
                $parameter->$methodName($value);
                break;
        }

        return $parameter;
    }

    protected function assignEntityValueFromParamConverter(RequestParameterList $requestParameterList, QueryInterface $query, QueryField $queryField): QueryInterface
    {
        if ($converter = $this->paramConverterFactory->createParamConverter($queryField->getType())) {
            $methodName = $queryField->getMethodName();
            $newParameterName = ClassUtil::getLowercaseShortnameFromFqcn($queryField->getType());

            $paramConverterConfiguration = new ParamConverter(['name' => $newParameterName]);

            $request = new Request($requestParameterList->getList());

            try {
                $converter->apply($request, $paramConverterConfiguration);
            } catch (NotFoundHttpException) {
                return $query;
            }

            $query->$methodName($request->get($newParameterName));
        }

        return $query;
    }

    protected function convertToInt(string $stringValue, string $parameterValue): int
    {
        // ^-?(\d+|\d{1,3}(?:\,\d{3})+)?(\.\d+)?$
//        if (!ctype_digit($stringValue)) {
        //          throw new ParameterConverterException('int', $stringValue, $parameterValue);
        //    }

        return (int)$stringValue;
    }
}
