<?php
namespace Vanio\ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder;
        $treeBuilder->root('vanio_api')
            ->children()
                ->booleanNode('format_listener')->defaultFalse()->end()
                ->booleanNode('request_body_listener')->defaultFalse()->end()
                ->booleanNode('access_denied_listener')->defaultFalse()->end()
                ->arrayNode('formats')
                    ->prototype('scalar')->end()
                    ->defaultValue(['json'])
                    ->beforeNormalization()
                        ->ifTrue(function ($value) {
                            return !is_array($value);
                        })
                        ->then(function ($value) {
                            return [$value];
                        })
                    ->end()
                ->end()
                ->arrayNode('limit_default_options')
                    ->children()
                        ->integerNode('default_limit')->end()
                    ->end()
                    ->addDefaultsIfNotSet()
                ->end()
                ->arrayNode('serializer_type_mapping')
                    ->prototype('scalar')->end()
                    ->defaultValue([])
                ->end()
            ->end();

        return $treeBuilder;
    }
}
