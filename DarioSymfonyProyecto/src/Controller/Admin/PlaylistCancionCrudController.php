<?php

namespace App\Controller\Admin;

use App\Entity\PlaylistCancion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class PlaylistCancionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlaylistCancion::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('playlist', 'Selecciona la playlist'),
            AssociationField::new('cancion', 'Selecciona la cancion que quieres añadir') 
        ];
    }
   
}
