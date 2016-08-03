<?php

class WebsiteKernel extends AppKernel
{
    const CONTEXT = self::CONTEXT_WEBSITE;

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
        $this->setContext(self::CONTEXT);
    }

    public function registerBundles()
    {
        $bundles = parent::registerBundles();

        $bundles[] = new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle();

        return $bundles;
    }
}
