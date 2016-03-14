<?php

class AdminKernel extends AppKernel
{
    const CONTEXT = self::CONTEXT_ADMIN;

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

        $bundles[] = new Symfony\Bundle\SecurityBundle\SecurityBundle();
        $bundles[] = new Sulu\Bundle\AdminBundle\SuluAdminBundle();
        $bundles[] = new Sulu\Bundle\CollaborationBundle\SuluCollaborationBundle();

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new Sulu\Bundle\GeneratorBundle\SuluGeneratorBundle();
        }

        return $bundles;
    }
}
