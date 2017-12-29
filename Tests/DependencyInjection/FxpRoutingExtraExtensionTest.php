<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Bundle\RoutingExtraBundle\Tests\DependencyInjection;

use Fxp\Bundle\RoutingExtraBundle\DependencyInjection\FxpRoutingExtraExtension;
use Fxp\Bundle\RoutingExtraBundle\FxpRoutingExtraBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\FrameworkExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class FxpRoutingExtraExtensionTest extends TestCase
{
    public function testExtensionExist()
    {
        $container = $this->createContainer();

        $this->assertTrue($container->hasExtension('fxp_routing_extra'));
    }

    public function testExtensionLoader()
    {
        $container = $this->createContainer();

        $this->assertTrue($container->hasDefinition('fxp_routing_extra.router_extra'));
    }

    protected function createContainer(array $configs = [])
    {
        $container = new ContainerBuilder(new ParameterBag([
            'kernel.bundles' => [
                'FrameworkBundle' => 'Symfony\\Bundle\\FrameworkBundle\\FrameworkBundle',
                'FxpRoutingExtraBundle' => 'Fxp\\Bundle\\RoutingExtraBundle\\FxpRoutingExtraBundle',
            ],
            'kernel.cache_dir' => sys_get_temp_dir().'/fxp_routing_extra_bundle',
            'kernel.debug' => false,
            'kernel.environment' => 'test',
            'kernel.name' => 'kernel',
            'kernel.root_dir' => sys_get_temp_dir().'/fxp_routing_extra_bundle',
            'kernel.charset' => 'UTF-8',
        ]));

        $sfExt = new FrameworkExtension();
        $extension = new FxpRoutingExtraExtension();

        $container->registerExtension($sfExt);
        $container->registerExtension($extension);

        $sfExt->load([[]], $container);
        $extension->load($configs, $container);

        $bundle = new FxpRoutingExtraBundle();
        $bundle->build($container);

        $container->getCompilerPassConfig()->setOptimizationPasses([]);
        $container->getCompilerPassConfig()->setRemovingPasses([]);
        $container->compile();

        return $container;
    }
}
