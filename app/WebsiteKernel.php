<?php

class WebsiteKernel extends AppKernel
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'website';

    /**
     * @param string $environment
     * @param bool   $debug
     */
    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);
        $this->setContext(self::CONTEXT_WEBSITE);
    }

    public function registerBundles()
    {
        $bundles = parent::registerBundles();

        $bundles[] = new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle();

        return $bundles;
    }
}
