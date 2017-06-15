<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\RoutingExtraBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Sonatra\Bundle\RoutingExtraBundle\DependencyInjection\SonatraRoutingExtraExtension;
use Sonatra\Bundle\RoutingExtraBundle\SonatraRoutingExtraBundle;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\FrameworkExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class SonatraRoutingExtraExtensionTest extends TestCase
{
    public function testExtensionExist()
    {
        $container = $this->createContainer();

        $this->assertTrue($container->hasExtension('sonatra_routing_extra'));
    }

    public function testExtensionLoader()
    {
        $container = $this->createContainer();

        $this->assertTrue($container->hasDefinition('sonatra_routing_extra.router_extra'));
    }

    protected function createContainer(array $configs = array())
    {
        $container = new ContainerBuilder(new ParameterBag(array(
            'kernel.bundles' => array(
                'FrameworkBundle' => 'Symfony\\Bundle\\FrameworkBundle\\FrameworkBundle',
                'SonatraRoutingExtraBundle' => 'Sonatra\\Bundle\\RoutingExtraBundle\\SonatraRoutingExtraBundle',
            ),
            'kernel.cache_dir' => sys_get_temp_dir().'/sonatra_routing_extra_bundle',
            'kernel.debug' => false,
            'kernel.environment' => 'test',
            'kernel.name' => 'kernel',
            'kernel.root_dir' => sys_get_temp_dir().'/sonatra_routing_extra_bundle',
            'kernel.charset' => 'UTF-8',
        )));

        $sfExt = new FrameworkExtension();
        $extension = new SonatraRoutingExtraExtension();

        $container->registerExtension($sfExt);
        $container->registerExtension($extension);

        $sfExt->load(array(array()), $container);
        $extension->load($configs, $container);

        $bundle = new SonatraRoutingExtraBundle();
        $bundle->build($container);

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->compile();

        return $container;
    }
}
