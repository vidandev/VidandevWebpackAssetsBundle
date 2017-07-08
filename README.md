# WebpackAssetsBundle
Webpack integration for Symfony.

Currently only supports including assets with path or from webpack dev server based on configuration.

Default configuration:
```yaml
vidandev_webpack_assets:
    dev_server:
        enabled: false
        host: http://localhost
        port: 9000
```