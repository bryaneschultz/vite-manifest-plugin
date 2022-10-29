<?php
/** @noinspection SpellCheckingInspection */
/**
 * Vite Manifest plugin for Craft CMS 4.x
 *
 * Twig utility function to handle Vite manifest asset files for Craft CMS.
 *
 * @link       https://github.com/bryaneschultz/vite-manifest-plugin
 * @copyright  Copyright (c) 2022 Bryan E. Schultz
 */

namespace bryaneschultz\vitemanifest;

use bryaneschultz\vitemanifest\services\ManifestService;
use bryaneschultz\vitemanifest\twigextensions\ManifestTwigExtension;

use Craft;
use craft\base\Plugin;

/**
 * @Class     ViteManifest
 * @ViteManifest
 * @extends   Plugin
 * @package   vite-manifest-plugin
 * @since     1.0.0
 *
 * @property-read  ManifestService  ManifestService
 */
class ViteManifest extends Plugin
{
    // Public Static Properties
    // =========================================================================

    /** @var ViteManifest */
    public static ViteManifest $plugin;

    // Public Methods
    // =========================================================================

    /** @inheritdoc */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'ManifestService' => ManifestService::class,
        ]);

        Craft::setAlias('@ViteManifest', $this->getBasePath());

        Craft::$app->getRequest()->setIsConsoleRequest(false);
        Craft::$app->view->registerTwigExtension(new ManifestTwigExtension());

        Craft::info(
            Craft::t(
                'vite-manifest',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }
}
