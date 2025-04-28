<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    //ici on va crée une ppté en privé
    private Security $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    //cette méthode est appelé just avant l'insertion des objets
    //on va l'utiliser pour dire à l'article quel est l'utilisateur qui l'a créé
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Article) return; //on vérifie que l'objet qu'on est en train d'insérer est bien un article, si ce n'est pas le cas tu return
        $user = $this->security->getUser(); //on récupère l'utilisateur actuellement connectée grace au service security de symfony
        $entityInstance->setUser($user); //on dit à l'article ton user est celui qui est connecté maintenant
        parent::persistEntity($entityManager, $entityInstance); //on appelle la méthode parent pour que l'insertion se fasse correctement
    }

    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextareaField::new('content'),
            ImageField::new('image')->setUploadDir('/public/images/') //ce chemin va chercher les images dans le dossier public/images
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setBasePath('images/')->setRequired(false),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('updatedAt')->hideOnForm(),
            AssociationField::new('category', 'Category')->setFormTypeOption('choice_label', 'name')
                ->setLabel('Catégories')
                ->formatValue(function ($value, $entity) {
                    // Récupère les noms des catégories
                    return implode(', ', $entity->getCategory()->map(function ($category) {
                        return $category->getName();
                    })->toArray());
                }),
            AssociationField::new('user', 'Users')->hideOnForm() //car j'ai pas besoin 
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
        // ceci va permettre d'afficher le détail de l'article en cliquant dessus 
    }
}
