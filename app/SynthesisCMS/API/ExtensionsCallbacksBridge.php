<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 26.03.2017
 * Time: 17:02
 */

namespace App\SynthesisCMS\API;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class ExtensionsCallbacksBridge
{
    public static function regenerateSitemap()
    {
        $robotsContents = "User-agent: *\nDisallow: /admin\n\nUser-agent: *\nDisallow: /profile\n\nUser-agent: *\nDisallow: /register\n\nUser-agent: *\nDisallow: /login\n\nUser-agent: *\nDisallow: /logout\n\nUser-agent: *\nDisallow: /profile\n\nSitemap: ";

        $robotsContents .= url("/sitemap.xml");

        file_put_contents(public_path("robots.txt"), $robotsContents);

        $sitemapGenerator = Sitemap::create();

        $count = 0;

        foreach (\Route::getRoutes()->getIterator() as $route) {
            if ($route->getActionName() == "Closure") {
                $count++;

                $uri = $route->uri;

                if (!\preg_match("/{.+}/", $uri)) {
                    $sitemapGenerator->add(Url::create($uri));
                }
            }
        }

        echo ("Now the sitemap contains " . $count . " records!\n");

        $sitemapGenerator->writeToFile(public_path("sitemap.xml"));
    }

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
        self::regenerateSitemap();

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
        self::regenerateSitemap();

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
        self::regenerateSitemap();

        $synthesiscmsExtensions = view()->shared("synthesiscmsExtensions");

        foreach ($synthesiscmsExtensions as $extensionPack) {
            $kernel = $extensionPack[0];
            $kernel->onRouteSaved($id);
        }
    }
}
