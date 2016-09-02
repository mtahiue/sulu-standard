<?php

class AdminKernel extends AppKernel
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'admin';

    /**
     * @param string $environment
     * @param bool   $debug
     */
    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);
        $this->setContext(self::CONTEXT_ADMIN);
    }

    public function registerBundles()
    {
        $bundles = parent::registerBundles();

        $bundles[] = new Symfony\Bundle\SecurityBundle\SecurityBundle();
        $bundles[] = new FOS\RestBundle\FOSRestBundle();
        $bundles[] = new Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle();
        $bundles[] = new Sulu\Bundle\AdminBundle\SuluAdminBundle();
        $bundles[] = new Sulu\Bundle\CollaborationBundle\SuluCollaborationBundle();
        $bundles[] = new Sulu\Bundle\PreviewBundle\SuluPreviewBundle();

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new Sulu\Bundle\GeneratorBundle\SuluGeneratorBundle();
        }

        return $bundles;
    }
}
