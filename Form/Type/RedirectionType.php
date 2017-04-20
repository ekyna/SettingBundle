<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Form\Type;

use Ekyna\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

use function Symfony\Component\Translation\t;

/**
 * Class RedirectionType
 * @package Ekyna\Bundle\SettingBundle\Form\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fromPath', Type\TextType::class, [
                'label'    => t('redirection.field.from_path', [], 'EkynaSetting'),
                'required' => true,
            ])
            ->add('toPath', Type\TextType::class, [
                'label'    => t('redirection.field.to_path', [], 'EkynaSetting'),
                'required' => true,
            ])
            ->add('enabled', Type\CheckboxType::class, [
                'label'    => t('field.enabled', [], 'EkynaUi'),
                'required' => false,
                'attr'     => [
                    'align_with_widget' => true,
                ],
            ])
            ->add('permanent', Type\CheckboxType::class, [
                'label'    => t('redirection.field.permanent', [], 'EkynaSetting'),
                'required' => false,
                'attr'     => [
                    'align_with_widget' => true,
                ],
            ]);
    }
}
