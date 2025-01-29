<?php

namespace App\Controller\Admin;

use App\Entity\Perfil;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PerfilCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Perfil::class;
    }

    
    /* public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('nombre'),
            TextEditorField::new('description'), 
        ];
    } */
   
}
