<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters\Filter;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;


class UserCrudController extends AbstractCrudController implements EventSubscriberInterface
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['hashPassword'],
            BeforeEntityUpdatedEvent::class => ['hashPassword'],
        ];
    }

    public function hashPassword($event): void
    {
        $user = $event->getEntityInstance();
        if (!$user instanceof User) {
            return;
        }

        if ($user->getPlainPassword()) {
            $hashed = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashed);
        }
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setPageTitle('index', 'Gestion des utilisateurs')
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield EmailField::new('email', 'Email');

        
        yield TextField::new('plainPassword', 'Mot de passe')
            ->setFormType(PasswordType::class)
            ->onlyOnForms()
            ->setRequired(true);

        yield TextField::new('nom', 'Nom');
        yield TextField::new('prenom', 'Prénom');
        yield TextField::new('surnom', 'Surnom');
        yield TextField::new('roleName', 'Rôle')->onlyOnIndex();

        yield ChoiceField::new('roles', 'Rôle(s)')
            ->setChoices([
                'Client' => 'ROLE_CLIENT',
                'Propriétaire' => 'ROLE_PROPRIETAIRE',
                'Admin' => 'ROLE_ADMIN',
            ])
            ->allowMultipleChoices()
            ->hideOnIndex();

        // В таблице (index) показываем страну и город отдельно
        yield TextField::new('emplacement.pays', 'Pays')->onlyOnIndex();
        yield TextField::new('emplacement.ville', 'Ville')->onlyOnIndex();

        // В формах редактирования / создания показываем список существующих эмпласманов
        yield AssociationField::new('emplacement', 'Pays / Ville')
            ->autocomplete()
            ->onlyOnForms();

        yield TextField::new('emplacement', 'Pays / Ville')
            ->onlyOnDetail()
            ->formatValue(function ($value, $entity) {
                if (!$entity->getEmplacement()) {
                    return 'Non défini';
                }
                return $entity->getEmplacement()->getPays().' - '.$entity->getEmplacement()->getVille();
            });

        yield TextField::new('adresse', 'Adresse');    

        yield DateField::new('date_de_naissance', 'Date de naissance')->hideOnIndex();

        yield ImageField::new('imageName', 'Photo')
            ->setUploadDir('public/uploads/profiles/')
            ->setBasePath('/uploads/profiles/')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false);

        yield DateTimeField::new('createdAt', 'Créé le')->onlyOnDetail();
        yield DateTimeField::new('updatedAt', 'Modifié le')->onlyOnDetail();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('roles');

    }

    public function deleteUser(AdminContext $context, EntityManagerInterface $entityManager)
        {
            $user = $context->getEntity()->getInstance();

            if ($user->getBiens()->count() > 0) {
                $this->addFlash('danger', 'Impossible de supprimer cet utilisateur : il possède encore des biens.');
                return $this->redirect($context->getReferrer());
            }

            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur supprimé avec succès.');
            return $this->redirectToRoute('admin');
        }

    public function configureActions(Actions $actions): Actions
    {
        // запрещаем удаление пользователей с Biens
        return $actions
           // ->disable(Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
