# VidandevWebpackAssetsBundle
Webpack integration for Symfony framework.

Currently only supports including assets with path or from webpack dev server based on configuration.

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
Default configuration:
```yaml
vidandev_webpack_assets:
    dev_server:
        enabled: false
        host: http://localhost
        port: 9000
```
It is recommended to enable the dev_server config only in ```config_dev.yml```.


## Usage
Use it like the built in ```asset``` twig function but with a ```webpack_``` prefix.
If ```dev_server``` is enabled in ```config.yml``` it will generate the urls for the assets on the webpack dev server
otherwise it will work like the built in ```asset``` twig function. 

```twig
<link rel="stylesheet" href="{{ webpack_asset('style.css') }}"/>
<script type="application/javascript" src="{{ webpack_asset('app.js') }}"></script>
```