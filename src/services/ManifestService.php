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

namespace bryaneschultz\vitemanifest\services;

use bryaneschultz\vitemanifest\ViteManifest;

use Craft;
use craft\base\Component;
use craft\helpers\ArrayHelper;
use craft\helpers\UrlHelper;
use Symfony\Component\Filesystem\Filesystem;

use yii\helpers\Json;

/**
 * @Class     ManifestService
 * @ManifestService
 * @extends   Component
 * @package   vite-manifest-plugin
 * @since     1.0.0
 *
 * @property-read string $path
 */
class ManifestService extends Component
{
    // Private Properties
    // =========================================================================

    /** @var Filesystem|null $_filesystem */
    private ?Filesystem $_filesystem;

    /** @var array|string[]|null $_config */
    private ?array $_config;

    /**
     * Regular expressions for manifest file.
     * @var    array|string[]
     * @since  1.0.0
     */
    private array $regex = [
        '/[.\/]?s?css[\/]?/i',
        '/[.\/]?[jt]s[\/]?/i',
    ];

    // Public Methods
    // =========================================================================

    /** @return void */
    public function init(): void
    {
        $defaultConfig = include ViteManifest::$plugin->getBasePath() . DIRECTORY_SEPARATOR . 'config.php';
        $overrideConfig = Craft::$app->getConfig()->getConfigFromFile('vite-manifest');

        $this->_filesystem = new Filesystem();
        $this->_config = ArrayHelper::merge($defaultConfig, $overrideConfig);

        parent::init();
    }

    /**
     * Get outputted version of the file name from the manifest file.
     * @param   string   $file The key name
     * @param   boolean  $html Generate HTML
     * @return  string
     * @since   1.0.0
     */
    public function manifest(string $file, bool $html = false): string
    {
        $manifest = $this->_read();

        if ($manifest && $file) {
            $key = $file;

            if (array_key_exists($key, $manifest)) {
                $path = ltrim($manifest[$key]['file'], '/');
                $path = $this->_config['viteDist'] . DIRECTORY_SEPARATOR . $path;

                return $this->_getUrl($path, $html);
            }
        }

        Craft::warning(
            Craft::t(
                'vite-manifest',
                'Unable to locate the key [{file}] in manifest file.',
                ['file' => $file]
            ),
            __METHOD__
        );

        return $this->_getUrl($file, $html);
    }

    // Private Methods
    // =========================================================================

    /**
     * Returns the path to the Vite manifest file.
     * @return   string
     * @since    1.0.0
     */
    private function _getPath(): string
    {
        $path = DIRECTORY_SEPARATOR . $this->_config['viteDist'] . DIRECTORY_SEPARATOR . $this->_config['manifestFile'];
        return Craft::getAlias($this->_config['webRootAlias']) . $path;
    }

    /**
     * Return the full url path of asset.
     * @param   string   $path
     * @param   boolean  $html
     * @return  string
     * @since   1.0.0
     */
    private function _getUrl(string $path, bool $html = false): string
    {
        $url = UrlHelper::url($path);

        if ($html && preg_match($this->regex[0], $url)) {
            return sprintf('<link rel="stylesheet" href="%s">', $url);
        }

        if ($html && preg_match($this->regex[1], $url)) {
            return sprintf('<script src="%s"></script>', $url);
        }

        return $url;
    }

    /**
     * Read and return the contents of the Vite manifest file.
     * @return  array|bool
     * @since   1.0.0
     */
    private function _read(): array|bool
    {
        if ($this->_filesystem->exists($this->_getPath())) {
            $manifest = file_get_contents($this->_getPath());

            return Json::decode($manifest, true);
        }

        Craft::warning(
            Craft::t(
                'vite-manifest',
                'Unable to locate manifest file.'
            ),
            __METHOD__
        );

        return false;
    }
}
