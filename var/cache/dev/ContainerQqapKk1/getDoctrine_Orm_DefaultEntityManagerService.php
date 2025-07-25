<?php

namespace ContainerQqapKk1;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDoctrine_Orm_DefaultEntityManagerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'doctrine.orm.default_entity_manager' shared service.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public static function do($container, $lazyLoad = true)
    {
        if (true === $lazyLoad) {
            return $container->services['doctrine.orm.default_entity_manager'] = new \ReflectionClass('Doctrine\ORM\EntityManager')->newLazyGhost(static function ($proxy) use ($container) { self::do($container, $proxy); });
        }

        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/src/Proxy/Autoloader.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/src/EntityManagerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/src/EntityManager.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/src/ManagerConfigurator.php';

        $instance = ($lazyLoad->__construct(($container->services['doctrine.dbal.default_connection'] ?? $container->load('getDoctrine_Dbal_DefaultConnectionService')), ($container->privates['doctrine.orm.default_configuration'] ?? $container->load('getDoctrine_Orm_DefaultConfigurationService')), ($container->privates['doctrine.dbal.default_connection.event_manager'] ?? $container->load('getDoctrine_Dbal_DefaultConnection_EventManagerService'))) && false ?: $lazyLoad);

        ($container->privates['doctrine.orm.default_manager_configurator'] ??= new \Doctrine\Bundle\DoctrineBundle\ManagerConfigurator([], []))->configure($instance);

        return $instance;
    }
}
