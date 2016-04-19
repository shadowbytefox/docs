<?php

namespace Bolt\Docs\Provider;

use Bolt\Docs\PageBuilder;
use Bolt\Docs\Documentation;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DocumentationServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        $container['documentation'] = function($container) {
            return new Documentation(
                $container['yaml_parser'],
                $container['documentation.page_builder'],
                $container['documentation.versions_dir'],
                $container['documentation.versions_file'],
                $container['documentation.versions.default'],
                $container['debug']
            );
        };

        $container['documentation.versions_dir'] = __DIR__ . '/../../version';
        $container['documentation.versions_file'] = __DIR__ . '/../../app/versions.yml';
        $container['documentation.versions.default'] = null;

        $container['documentation.page_builder'] = function($container) {
            return new PageBuilder(
                $container['slugify'],
                $container['markdown'],
                $container['yaml_parser'],
                $container['config_cache_factory'],
                $container['documentation.page_builder.cache_dir']
            );
        };
        $container['documentation.page_builder.cache_dir'] = null;
    }
}