<?php

namespace App\Controller\Admin;

use App\Entity\Cancion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CancionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cancion::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titulo', 'Título'),
            IntegerField::new('duracion', 'Duración (segundos)'),
            TextField::new('album', 'Álbum'),
            TextField::new('autor', 'Autor'),
            IntegerField::new('reproducciones', 'Reproducciones'),
            IntegerField::new('likes', 'Likes'),
            AssociationField::new('genero', 'Género') // Este permite seleccionar un Estilo
        ];
    }
   
}
