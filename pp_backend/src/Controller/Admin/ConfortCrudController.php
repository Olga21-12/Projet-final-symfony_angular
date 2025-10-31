<?php

namespace App\Controller\Admin;

use App\Entity\Confort;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ConfortCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Confort::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom du confort');
    }
}

