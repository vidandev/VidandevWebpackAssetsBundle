<?php

namespace Vidandev\WebpackAssetsBundle\Twig\Extension;

use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Component\Config\Definition\Exception\Exception;
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
     * @param $packageName
     * @param bool $liveEnabled
     * @return string
     */
    public function getWebpackAssetUrl($path, $packageName = null, $liveEnabled = true)
    {
        if (!$this->isLiveAssetLoadingEnabled($liveEnabled)){
            return $this->assetExtension->getAssetUrl($path, $packageName);
        }

        return $this->generateLiveAssetUrl($path, $packageName);
    }

    /**
     * @param bool $liveEnabled
     * @return bool
     * @throws \Exception
     */
    private function isLiveAssetLoadingEnabled($liveEnabled)
    {
        if (!array_key_exists('dev_server', $this->config)) {
            throw new \Exception(sprintf('VidandevWebpackAssetsBundle is not configured properly. 
            No dev_server key found in configuration. %s - line: %s', __METHOD__, __LINE__));
        }

        return ((true === $liveEnabled) && ($this->config['dev_server']['enabled']));
    }

    private function generateLiveAssetUrl($path, $packageName = null)
    {
        $devServerConfig = $this->config['dev_server'];

        $liveAssetUrl = [];

        $host = $devServerConfig['host'];
        $port = $devServerConfig['port'];

        $liveAssetUrl[] = $host;

        if ($port && $host) {
            $liveAssetUrl[] = ':';
            $liveAssetUrl[] = $port;
        }

        $liveAssetUrl[] = '/';

        $subPath = $this->assetExtension->getAssetUrl($path, $packageName);
        $liveAssetUrl[] = $this->preparePath($subPath);

        return implode("", $liveAssetUrl);
    }

    private function preparePath($subPath)
    {
        $webPosition = strpos($subPath, 'web/');

        if ($webPosition) {
            $shortPath = substr($subPath, $webPosition + 4);
        } else {
            $shortPath = $subPath;
        }

        $trimmedPath = trim($shortPath, '/');

        return 'web/' . $trimmedPath;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'webpack_asset';
    }
}