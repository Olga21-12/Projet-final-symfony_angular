<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('bien', 'Bien lié')->autocomplete();

        yield TextField::new('imageFile', 'Téléverser la photo')
            ->setFormType(VichImageType::class)
            ->onlyOnForms()
            ->setFormTypeOptions([
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
            ]);

        yield ImageField::new('imageName', 'Aperçu')
            ->setBasePath('/uploads/biens/')
            ->onlyOnIndex()
            ->setRequired(false);
    }
}
