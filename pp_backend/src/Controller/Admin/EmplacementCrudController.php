<?php

namespace App\Controller\Admin;

use App\Entity\Emplacement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class EmplacementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Emplacement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            TextField::new('pays', 'Pays')
                ->setHelp('Nom du pays (ex: Belgique)')
                ->setRequired(true),

            TextField::new('ville', 'Ville')
                ->setHelp('Nom de la ville (ex: Bruxelles)')
                ->setRequired(true),

            IntegerField::new('code_postal', 'Code postal')
                ->setHelp('Ex: 1000'),
        ];
    }
}
