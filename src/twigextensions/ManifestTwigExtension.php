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

namespace bryaneschultz\vitemanifest\twigextensions;

use bryaneschultz\vitemanifest\ViteManifest;

use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFunction;

/**
 * @Class    ManifestTwigExtension
 * @ManifestTwigExtension
 * @extends  AbstractExtension
 * @author   Bryan E. Schultz
 * @package  vite-manifest-plugin
 * @since    1.0.0
 */
class ManifestTwigExtension extends AbstractExtension
{
    /** @inheritdoc */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('manifest',
                [$this, 'manifest'],
                ['is_safe' => ['html'], 'preserves_safety' => true]),
        ];
    }

    /**
     * Returns the outputted version of the file name from the manifest file.
     * @param   string   $file     The key name
     * @param   boolean  $html     Generate HTML
     * @return  string
     * @since   1.0.0
     */
    public function manifest(string $file, bool $html = false): string
    {
        if ($html) {
            $markup = ViteManifest::$plugin->ManifestService->manifest($file, true);

            return new Markup($markup, 'utf-8');
        }

        return ViteManifest::$plugin->ManifestService->manifest($file);
    }
}
