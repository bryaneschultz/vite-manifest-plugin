# Vite Manifest plugin for Craft CMS 4.x

![Screenshot](resources/img/plugin-logo.svg)

## Requirements

This plugin requires Craft CMS 4.x or later.

## Installation

### 1. Install with Composer

From the terminal

```
cd /path/to/project
composer require bryaneschultz/vite-manifest-plugin
```

### 2. Install through Craft CMS

In the Control Panel, go to `Settings` → `Plugins` → `Vite Manifest` → `Install`

## Vite Manifest Overview

Lightweight Twig utility function to handle Vite Manifest files for Craft CMS.

## Configuring Vite Manifest

Vite Manifest comes with basic configuration. To override these configuration keys,
copy the contents of the `config.php` file to `config/vite-manifest.php`

```
[
    'webRootAlias' => '@webroot',
    'manifestFile' => 'manifest.json',
    'viteDist' => 'dist',
]
```

## Using Vite Manifest

### Basic Usage.

By default, Vite Manifest will use the version supplied by the manifest.

```
<link rel="stylesheet" href="{{ manifest('css/app.css') }}" />
<script src="{{ manifest('js/app.ts') }}"></script>
```

### Advanced Usage.

If you want twig to handle the html for your asset, pass `true` as a second parameter.

```
{{ manifest('css/app.scss', true) }}
{{ manifest('js/app.ts', true) }}
```

## License
Vite Manifest is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT/).

## Vite Manifest Roadmap

* [Initial release](https://github.com/bryaneschultz/vite-manifest-plugin/blob/main/CHANGELOG.md)

Brought to you by [Bryan E. Schultz](https://github.com/bryaneschultz)
