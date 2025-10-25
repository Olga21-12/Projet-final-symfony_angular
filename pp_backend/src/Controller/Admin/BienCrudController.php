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
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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

        yield TextField::new('adresse', 'Adresse');
        yield TextEditorField::new('description', 'Description');
        yield NumberField::new('prix', 'Prix (€)');
        yield NumberField::new('surface', 'Surface (m²)');
        yield NumberField::new('nombre_de_chambres', 'Chambres');
        yield BooleanField::new('disponibilite', 'Disponible');
        yield BooleanField::new('luxe', 'Luxe');

        yield AssociationField::new('type_de_bien', 'Type de bien')->autocomplete();
        yield AssociationField::new('typeActivite', 'Type d’activité')->autocomplete();
        yield AssociationField::new('conforts', 'Conforts')->autocomplete();
        
        yield TextField::new('emplacement.pays', 'Pays')->onlyOnIndex();
        yield TextField::new('emplacement.ville', 'Ville')->onlyOnIndex();

        yield AssociationField::new('emplacement', 'Pays / Ville')
            ->autocomplete()
            ->onlyOnForms();
        
            yield AssociationField::new('user', 'Propriétaire')->autocomplete();

        yield ImageField::new('image', 'Photo principale')
            ->setUploadDir('public/uploads/biens/')
            ->setBasePath('/uploads/biens/')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->setRequired(false);

        yield DateTimeField::new('createdAt', 'Créé le')->onlyOnDetail();
        yield DateTimeField::new('updatedAt', 'Modifié le')->onlyOnDetail();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            
            ->add('type_de_bien')
            ->add('typeActivite')
            ->add('disponibilite')
            ->add('prix')
            ->add('luxe');
    }
}
