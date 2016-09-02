<?php

use Sulu\Component\HttpKernel\SuluKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

abstract class AppKernel extends SuluKernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Lexik\Bundle\MaintenanceBundle\LexikMaintenanceBundle(),
            new Liip\MonitorBundle\LiipMonitorBundle(),

            new Sulu\Bundle\CoreBundle\SuluCoreBundle(),
            new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),

            // Symfony CMF
            new Symfony\Cmf\Bundle\CoreBundle\CmfCoreBundle(),

            // Doctrine Extensions
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            // REST
            new JMS\SerializerBundle\JMSSerializerBundle(),

            // Massive
            new Massive\Bundle\SearchBundle\MassiveSearchBundle(),

            // Sulu
            new Sulu\Bundle\SearchBundle\SuluSearchBundle(),
            new Sulu\Bundle\PersistenceBundle\SuluPersistenceBundle(),
            new Sulu\Bundle\ContactBundle\SuluContactBundle(),
            new Sulu\Bundle\MediaBundle\SuluMediaBundle(),
            new Sulu\Bundle\SecurityBundle\SuluSecurityBundle(),
            new Sulu\Bundle\CategoryBundle\SuluCategoryBundle(),
            new Sulu\Bundle\SnippetBundle\SuluSnippetBundle(),
            new Sulu\Bundle\ContentBundle\SuluContentBundle(),
            new Sulu\Bundle\TagBundle\SuluTagBundle(),
            new Sulu\Bundle\WebsiteBundle\SuluWebsiteBundle(),
            new Sulu\Bundle\LocationBundle\SuluLocationBundle(),
            new Sulu\Bundle\HttpCacheBundle\SuluHttpCacheBundle(),
            new Sulu\Bundle\WebsocketBundle\SuluWebsocketBundle(),
            new Sulu\Bundle\TranslateBundle\SuluTranslateBundle(),
            new Sulu\Bundle\DocumentManagerBundle\SuluDocumentManagerBundle(),
            new Sulu\Bundle\HashBundle\SuluHashBundle(),
            new Sulu\Bundle\CustomUrlBundle\SuluCustomUrlBundle(),
            new Sulu\Bundle\RouteBundle\SuluRouteBundle(),
            new Sulu\Bundle\MarkupBundle\SuluMarkupBundle(),
            new DTL\Bundle\PhpcrMigrations\PhpcrMigrationsBundle(),
            new Dubture\FFmpegBundle\DubtureFFmpegBundle(),

            // Tools
            new Massive\Bundle\BuildBundle\MassiveBuildBundle(),

            new AppBundle\AppBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Fidry\PsyshBundle\PsyshBundle();
            $bundles[] = new Sulu\Bundle\TestBundle\SuluTestBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        if ('vagrant' === getenv('USER')) {
            return '/opt/symfony/cache/'.$this->getContext().'/'.$this->getEnvironment();
        }

        return dirname(__DIR__).'/var/cache/'.$this->getContext().'/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        if ('vagrant' === getenv('USER')) {
            return '/opt/symfony/logs';
        }

        return dirname(__DIR__).'/var/logs/'.$this->getContext();
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/'.$this->getContext().'/config_'.$this->getEnvironment().'.yml');

        // @see https://github.com/symfony/symfony/issues/7555
        $loader->load(function(\Symfony\Component\DependencyInjection\Container $container) {
            $container->getParameterBag()->add($this->getEnvParameters());
        });
    }

    protected function getKernelParameters()
    {
        return array_merge(
            parent::getKernelParameters(),
            [
                'kernel.var_dir' => dirname(__DIR__).'/var'
            ]
        );
    }
}
