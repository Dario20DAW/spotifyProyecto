<?php
namespace App\Form;

use App\Entity\Playlist;
use App\Entity\Cancion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaylistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre de la Playlist',
            ])
            ->add('visibilidad', CheckboxType::class, [
                'label' => '¿Es pública?',
                'required' => false,
            ])
            ->add('canciones', EntityType::class, [
                'class' => Cancion::class,
                'choice_label' => 'titulo',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Selecciona las canciones',
                'mapped' => false, 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Playlist::class,
        ]);
    }
}