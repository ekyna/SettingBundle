<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Ekyna\Bundle\SettingBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ekyna_setting');

        $rootNode
            ->children()
                ->scalarNode('output_dir')->defaultValue('')->end()
                ->arrayNode('helper_remotes')
                    ->treatNullLike([])
                    ->prototype('scalar')->end()
                    ->defaultValue([])
                ->end()
                ->append($this->getPoolsSection())
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * Returns the pools configuration definition.
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getPoolsSection()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('pools');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('helper')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->variableNode('templates')->defaultValue([
                            '_form.html' => '@EkynaSetting/Admin/Helper/_form.html',
                            'show.html'  => '@EkynaSetting/Admin/Helper/show.html',
                        ])->end()
                        ->scalarNode('parent')->end()
                        ->scalarNode('entity')->defaultValue('Ekyna\Bundle\SettingBundle\Entity\Helper')->end()
                        ->scalarNode('controller')->defaultValue('Ekyna\Bundle\SettingBundle\Controller\Admin\HelperController')->end()
                        ->scalarNode('operator')->end()
                        ->scalarNode('repository')->defaultValue('Ekyna\Bundle\SettingBundle\Repository\HelperRepository')->end()
                        ->scalarNode('form')->defaultValue('Ekyna\Bundle\SettingBundle\Form\Type\HelperType')->end()
                        ->scalarNode('table')->defaultValue('Ekyna\Bundle\SettingBundle\Table\Type\HelperType')->end()
                    ->end()
                ->end()
                ->arrayNode('redirection')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->variableNode('templates')->defaultValue([
                            '_form.html' => '@EkynaSetting/Admin/Redirection/_form.html',
                            'show.html'  => '@EkynaSetting/Admin/Redirection/show.html',
                        ])->end()
                        ->scalarNode('parent')->end()
                        ->scalarNode('entity')->defaultValue('Ekyna\Bundle\SettingBundle\Entity\Redirection')->end()
                        ->scalarNode('controller')->defaultValue('Ekyna\Bundle\SettingBundle\Controller\Admin\RedirectionController')->end()
                        ->scalarNode('operator')->end()
                        ->scalarNode('repository')->defaultValue('Ekyna\Bundle\SettingBundle\Repository\RedirectionRepository')->end()
                        ->scalarNode('form')->defaultValue('Ekyna\Bundle\SettingBundle\Form\Type\RedirectionType')->end()
                        ->scalarNode('table')->defaultValue('Ekyna\Bundle\SettingBundle\Table\Type\RedirectionType')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}
