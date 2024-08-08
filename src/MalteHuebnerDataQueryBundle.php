<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle;

use MalteHuebner\DataQueryBundle\DependencyInjection\Compiler\ParameterPass;
use MalteHuebner\DataQueryBundle\DependencyInjection\Compiler\QueryPass;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MalteHuebnerDataQueryBundle extends Bundle
{
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    #[\Override]
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ParameterPass());
        $container->addCompilerPass(new QueryPass());

        $container->registerForAutoconfiguration(QueryInterface::class)->addTag('data_query.query');
        $container->registerForAutoconfiguration(ParameterInterface::class)->addTag('data_query.parameter');

    }
}
