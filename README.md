# VidandevWebpackAssetsBundle
Webpack integration for the Symfony framework.

Currently only supports the inclusion of static assets from the filesystem or from 'webpack dev server' based on configuration.

## Installation
1. Add repository to ```composer.json```
    ```
    {
        // ...
        "repositories" : [{
            "type" : "git",
            "url" : "https://github.com/vidandev/WebpackAssetsBundle.git"
        }],
        // ...
    }
    ```
2. Install the bundle with composer:
    ```
    php composer.phar require vidandev/webpack-assets-bundle
    ```

3. Enable the bundle in ```AppKernel.php```:
    ```php
    $bundles = [
        // ...
        new Vidandev\WebpackAssetsBundle\VidandevWebpackAssetsBundle(),      
        // ...
    ];
    ```

## Configuration
It is recommended to enable the dev_server config only in ```config_dev.yml```.

Minimal configuration to get assets from webpack dev server:
```yaml
vidandev_webpack_assets:
    dev_server:
        enabled: true
```

Default configuration:
```yaml
vidandev_webpack_assets:
    dev_server:
        enabled: false
        host: http://localhost
        port: 8000
```


## Usage
Use it like the built in Asset Component's ```asset``` twig function but with a ```webpack_``` prefix.

If ```dev_server``` is enabled in ```config.yml``` it will generate the urls for the assets on the 'webpack dev server'
otherwise it will work like the ```asset``` function.

```twig
<link rel="stylesheet" href="{{ webpack_asset('style.css') }}"/>
<script type="application/javascript" src="{{ webpack_asset('app.js') }}"></script>
```

#### Asset Packages
You can use the Asset Components packages like this:
```twig
<link rel="stylesheet" href="{{ webpack_asset('style.css', 'static/css') }}"/>
```
Or you can pass null instead of package name:
```twig
<link rel="stylesheet" href="{{ webpack_asset('style.css', null) }}"/>
```
#### Force filesystem inclusion
You can force the inclusion of assets from filesystem instead of using the ones on the 'webpack dev server':
```twig
<link rel="stylesheet" href="{{ webpack_asset('style.css', null, false) }}"/>
```