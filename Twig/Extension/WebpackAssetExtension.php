<?php

namespace Vidandev\WebpackAssetsBundle\Twig\Extension;

use Symfony\Bridge\Twig\Extension\AssetExtension;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class WebpackAssetExtension extends AbstractExtension
{
    /**
     * @var AssetExtension
     */
    private $assetExtension;

    /**
     * @var array
     */
    private $config;

    /**
     * @param AssetExtension $assetExtension
     * @param array $config
     */
    public function __construct(AssetExtension $assetExtension, $config)
    {
        $this->assetExtension = $assetExtension;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('webpack_asset', array($this, 'getWebpackAssetUrl')),
        );
    }

    /**
     * @param $path
     * @param bool $live
     * @param $packageName
     * @return string
     */
    public function getWebpackAssetUrl($path, $live = true, $packageName = null)
    {
        $devServerConfig = $this->config['dev_server'];

        if ((false === $live) || (false === $devServerConfig['enabled'])) {
            return $this->assetExtension->getAssetUrl($path, $packageName);
        }

        $liveAssetUrl = $devServerConfig['host'];

        if ($port = $devServerConfig['port']) {
            $liveAssetUrl .= (':' . $port);
        }

        $subPath = $this->assetExtension->getAssetUrl($path, $packageName);
        $preparedPath = substr($subPath, strpos($subPath, 'web/'));

        return $liveAssetUrl . '/' .$preparedPath;
    }
}