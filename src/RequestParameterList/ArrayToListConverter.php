<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\RequestParameterList;

class ArrayToListConverter
{
    private function __construct()
    {

    }

    public static function convert(array $array): RequestParameterList
    {
        $requestParameterList = new RequestParameterList();

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = implode(',', $value);
            }

            $requestParameterList->add($key, (string) $value);
        }

        return $requestParameterList;
    }
}
