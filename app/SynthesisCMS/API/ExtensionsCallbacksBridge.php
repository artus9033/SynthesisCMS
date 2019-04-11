<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 26.03.2017
 * Time: 17:02
 */

namespace App\SynthesisCMS\API;

class ExtensionsCallbacksBridge
{
    /**
     * Function that executes onArticleDeleted function on every extension that overrides this method
     * @param $id int id of the article deleted
     */
    public static function handleOnArticleDeleted($id)
    {
        $synthesiscmsExtensions = view()->shared("synthesiscmsExtensions");

        foreach ($synthesiscmsExtensions as $extensionPack) {
            $kernel = $extensionPack[0];
            $kernel->onArticleDeleted($id);
        }
    }

    /**
     * Function that executes onArticleCategoryDeleted function on every extension that overrides this method
     * @param $id int id of the articleCategory deleted
     */
    public static function handleOnArticleCategoryDeleted($id)
    {
        $synthesiscmsExtensions = view()->shared("synthesiscmsExtensions");

        foreach ($synthesiscmsExtensions as $extensionPack) {
            $kernel = $extensionPack[0];
            $kernel->onArticleCategoryDeleted($id);
        }
    }

    /**
     * Function that executes onRouteDeleted function on every extension that overrides this method
     * @param $id int id of the page deleted
     */
    public static function handleOnRouteDeleted($id)
    {
        $synthesiscmsExtensions = view()->shared("synthesiscmsExtensions");

        foreach ($synthesiscmsExtensions as $extensionPack) {
            $kernel = $extensionPack[0];
            $kernel->onRouteDeleted($id);
        }
    }

    /**
     * Function that executes onRouteCreated function on every extension that overrides this method
     * @param $id int id of the page created
     */
    public static function handleOnRouteCreated($id)
    {
        $synthesiscmsExtensions = view()->shared("synthesiscmsExtensions");

        foreach ($synthesiscmsExtensions as $extensionPack) {
            $kernel = $extensionPack[0];
            $kernel->onRouteCreated($id);
        }
    }

    /**
     * Function that executes onRouteSaved function on every extension that overrides this method
     * @param $id int id of the page saved
     */
    public static function handleOnRouteSaved($id)
    {
        $synthesiscmsExtensions = view()->shared("synthesiscmsExtensions");

        foreach ($synthesiscmsExtensions as $extensionPack) {
            $kernel = $extensionPack[0];
            $kernel->onRouteSaved($id);
        }
    }
}
