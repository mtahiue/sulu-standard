<?php

class WebsiteKernel extends AppKernel
{
    const CONTEXT = self::CONTEXT_WEBSITE;

    /**
     * @param string $environment
     * @param bool   $debug
     */
    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug, self::CONTEXT);
    }

    public function registerBundles()
    {
        $bundles = parent::registerBundles();

        $bundles[] = new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle();

        return $bundles;
    }
}
