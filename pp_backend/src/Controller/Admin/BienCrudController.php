<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class BienCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bien::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Bien immobilier')
            ->setEntityLabelInPlural('Biens immobiliers')
            ->setPageTitle('index', 'Gestion des biens')
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();

        yield AssociationField::new('emplacement', 'Pays / Ville')->autocomplete();
        yield TextField::new('adresse', 'Adresse');
        yield AssociationField::new('user', 'Propriétaire')->autocomplete();
        yield TextEditorField::new('description', 'Description');
        yield NumberField::new('prix', 'Prix (€)');
        yield NumberField::new('surface', 'Surface (m²)');
        yield NumberField::new('nombre_de_chambres', 'Chambres');
        yield AssociationField::new('type', 'Type de bien')->autocomplete();
        yield AssociationField::new('typeActivite', 'Type d’activité')->autocomplete();
        yield BooleanField::new('disponibilite', 'Disponible');
        yield BooleanField::new('luxe', 'Luxe');

        yield AssociationField::new('confort', 'Conforts')
            ->setFormTypeOptions([
                'by_reference' => false,
                'multiple' => true,
                'expanded' => true, // чекбоксы
            ])
            ->onlyOnForms();

        yield CollectionField::new('confort', 'Conforts')
            ->setTemplatePath('admin/fields/conforts.html.twig')
            ->onlyOnDetail();    

        yield CollectionField::new('confort', 'Conforts')
            ->setTemplatePath('admin/fields/conforts.html.twig')
            ->onlyOnDetail();
        
        //  Dates
        yield DateTimeField::new('createdAt', 'Créé le')->onlyOnDetail();
        yield DateTimeField::new('updatedAt', 'Modifié le')->onlyOnDetail();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL); 
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters

            ->add('type')
            ->add('typeActivite')
            ->add('emplacement')
            ->add('user')
            ->add('disponibilite')
            ->add('prix')
            ->add('luxe');
    }
}
