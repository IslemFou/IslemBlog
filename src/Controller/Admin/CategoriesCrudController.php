<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categories::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            //on rajoute une fonction hideOnForm() pour ne pas afficher l'id dans le formulaire
            IdField::new('id')->hideOnForm()
                //pour ne pas afficher l'id dans l'index
                ->hideOnIndex(),
            TextField::new('name'),
            TextareaField::new('description'),
            DateTimeField::new('createdAt'),
            // DateTimeField::new('createdAt')->hideOnForm(), // ca va pas fonctionner, donc on va gérer ca dans l'entity categories.php et on va au constructeur
            DateTimeField::new('updatedAt')->hideOnForm(),
        ];
    }
}
