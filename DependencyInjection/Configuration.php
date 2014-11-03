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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ekyna_setting');

        $rootNode
            ->children()
                ->scalarNode('output_dir')->defaultValue('')->end()
                ->arrayNode('helper_remotes')
                    ->treatNullLike(array())
                    ->prototype('scalar')->end()
                    ->defaultValue(array())
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
						->variableNode('templates')->defaultValue(array(
							'_form.html' => 'EkynaSettingBundle:Helper/Admin:_form.html',
							'show.html'  => 'EkynaSettingBundle:Helper/Admin:show.html',
						))->end()
						->scalarNode('parent')->end()
						->scalarNode('entity')->defaultValue('Ekyna\Bundle\SettingBundle\Entity\Helper')->end()
						->scalarNode('controller')->defaultValue('Ekyna\Bundle\SettingBundle\Controller\Admin\HelperController')->end()
						->scalarNode('operator')->end()
						->scalarNode('repository')->defaultValue('Ekyna\Bundle\SettingBundle\Entity\HelperRepository')->end()
						->scalarNode('form')->defaultValue('Ekyna\Bundle\SettingBundle\Form\Type\HelperType')->end()
						->scalarNode('table')->defaultValue('Ekyna\Bundle\SettingBundle\Table\Type\HelperType')->end()
					->end()
				->end()
			->end()
        ;

        return $node;
    }
}
