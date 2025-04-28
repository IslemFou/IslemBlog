<?php

namespace App\Controller\Admin;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProfilCrudController extends AbstractCrudController
{
    private Security $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public static function getEntityFqcn(): string
    {
        return Profil::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Profil) return; //on vérifie que l'objet qu'on est en train d'insérer est bien un article, si ce n'est pas le cas tu return
        $user = $this->security->getUser(); //on récupère l'utilisateur actuellement connectée grace au service security de symfony
        $entityInstance->setUser($user); //on dit à l'article ton user est celui qui est connecté maintenant
        parent::persistEntity($entityManager, $entityInstance); //on appelle la méthode parent pour que l'insertion se fasse correctement
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex()->hideOnForm(),

            TextareaField::new('Description')->setMaxLength(255)->setRequired(false),
            ImageField::new('picture')->setUploadDir('/public/images/') //ce chemin va chercher les images dans le dossier public/images
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setBasePath('images/')->setRequired(false),
            DateField::new('dateBirth'),
            AssociationField::new('user', 'Users')->hideOnForm() //car j'ai pas besoin 


        ];
    }
}
