<?php

namespace ContainerQqapKk1;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getFavoritePoiControllerlistService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.fB1cJ6X.App\Controller\FavoritePoiController::list()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.fB1cJ6X.App\\Controller\\FavoritePoiController::list()'] = (new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'repo' => ['privates', 'App\\Repository\\FavoritePoiRepository', 'getFavoritePoiRepositoryService', true],
        ], [
            'repo' => 'App\\Repository\\FavoritePoiRepository',
        ]))->withContext('App\\Controller\\FavoritePoiController::list()', $container);
    }
}
