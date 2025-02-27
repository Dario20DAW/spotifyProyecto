<?php

namespace App\Controller\Admin;

use App\Entity\Playlist;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlaylistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Playlist::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre', 'Nombre de la Playlist'),
            BooleanField::new('visibilidad', 'Visibilidad'),
            IntegerField::new('reproducciones', 'Reproducciones'),
            IntegerField::new('likes', 'Likes'),
            CollectionField::new('playlistCanciones', 'Canciones')->useEntryCrudForm(PlaylistCancionCrudController::class),
        ];
    }
   
}
