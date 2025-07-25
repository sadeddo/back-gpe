<?php

namespace ContainerQqapKk1;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getFavoriteLocationControllerremoveService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.ICsE.Iz.App\Controller\FavoriteLocationController::remove()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.ICsE.Iz.App\\Controller\\FavoriteLocationController::remove()'] = (new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'repo' => ['privates', 'App\\Repository\\FavoriteLocationRepository', 'getFavoriteLocationRepositoryService', true],
            'em' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', true],
        ], [
            'repo' => 'App\\Repository\\FavoriteLocationRepository',
            'em' => '?',
        ]))->withContext('App\\Controller\\FavoriteLocationController::remove()', $container);
    }
}
