<?php

namespace App\Controller\Admin;

use App\Entity\TypesDeBien;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypesDeBienCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypesDeBien::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('type_de_bien', 'Type de bien')
                ->setHelp('Exemple : Maison, Appartement, Studio, etc.')
                ->setRequired(true),
        ];
    }
}
