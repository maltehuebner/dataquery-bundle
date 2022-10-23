<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle;

use MalteHuebner\DataQueryBundle\DependencyInjection\Compiler\ParameterPass;
use MalteHuebner\DataQueryBundle\DependencyInjection\Compiler\QueryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MalteHuebnerDataQueryBundle extends Bundle
{
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ParameterPass());
        $container->addCompilerPass(new QueryPass());
    }
}
