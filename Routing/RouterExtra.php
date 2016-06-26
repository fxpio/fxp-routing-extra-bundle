<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\RoutingExtraBundle\Routing;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class RouterExtra implements RouterExtraInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var PropertyPathMatcher
     */
    private $matcher;

    /**
     * Constructor.
     *
     * @param RouterInterface           $router           The rooter
     * @param PropertyAccessorInterface $propertyAccessor The property accessor
     */
    public function __construct(RouterInterface $router, PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->router = $router;
        $this->matcher = new PropertyPathMatcher($propertyAccessor);
    }

    /**
     * {@inheritdoc}
     */
    public function generate($name, array $parameters, $data, $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        if (null !== $data) {
            $parameters = $this->matcher->matchRouteParameters($parameters, $data);
        }

        return $this->router->generate($name, $parameters, $referenceType);
    }
}
