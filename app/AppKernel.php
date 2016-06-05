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
            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),

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
            new DTL\Bundle\PhpcrMigrations\PhpcrMigrationsBundle(),
            new Dubture\FFmpegBundle\DubtureFFmpegBundle(),

            // Tools
            new Massive\Bundle\BuildBundle\MassiveBuildBundle(),

            // Website
            new Liip\ThemeBundle\LiipThemeBundle(),

            new Client\Bundle\WebsiteBundle\ClientWebsiteBundle(),
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
        return dirname(__DIR__).'/var/cache/'.$this->getContext().'/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs'.$this->getContext();
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/'.$this->getContext().'/config_'.$this->getEnvironment().'.yml');
    }
}
