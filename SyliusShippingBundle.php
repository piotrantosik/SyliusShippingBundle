<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ShippingBundle;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Bundle\ShippingBundle\DependencyInjection\Compiler\RegisterCalculatorsPass;
use Sylius\Bundle\ShippingBundle\DependencyInjection\Compiler\RegisterRuleCheckersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Shipping component for Symfony2 applications.
 * It is used as a base for shipments management system inside Sylius.
 *
 * It is fully decoupled, so you can integrate it into your existing project.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusShippingBundle extends Bundle
{
    /**
     * Return array of currently supported database drivers.
     *
     * @return array
     */
    public static function getSupportedDrivers()
    {
        return array(
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Sylius\Bundle\ShippingBundle\Model\ShipmentInterface'         => 'sylius.model.shipment.class',
            'Sylius\Bundle\ShippingBundle\Model\ShipmentItemInterface'     => 'sylius.model.shipment_item.class',
            'Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface' => 'sylius.model.shipping_category.class',
            'Sylius\Bundle\ShippingBundle\Model\ShippingMethodInterface'   => 'sylius.model.shipping_method.class',
            'Sylius\Bundle\ShippingBundle\Model\RuleInterface'             => 'sylius.model.shipping_rule.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('sylius_shipping', $interfaces));
        $container->addCompilerPass(new RegisterCalculatorsPass());
        $container->addCompilerPass(new RegisterRuleCheckersPass());
    }
}
