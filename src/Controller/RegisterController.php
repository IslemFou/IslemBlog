<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface, EntityManagerInterface $entityManagerInterface): Response //le mécanisme de gestion des dépendences est appelé autowiring
    // le mécanisme d'injection de dépendance en symfony => il s'agit de dire au symfony aue je veux que tu rentre dans cette action en ambarquant avec toi l'objet $request qui est une instance stocké dans une variable
    //  // Il faut que mon formulaire écoute et analyse la requete qui viens de la vue et vérifier s'il y a un post envoyé ou pas 
    // On utilise l'objet request crée pas symfony  et qui représente la requet HTTP entrante ( ici la requete contient des données de formulaire )
    //injection de userPasswordHasherInterface

    {
        if ($this->getUser()) { //si l'utilisateur est déjà connecté, on le redirige vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }
        $user = new Users; //on crée un nouvel utilisateur pour le formulaire
        $form = $this->createForm(RegisterType::class, $user); //btn droit et importer la classe RegisterType.php pour le formulaire d'inscription 

        $form->handleRequest($request); //on demande au formulaire de traiter la request, on va l'insérer dans les parametre index
        // cette méthode est utilisépour traiter les donées soumises par l'utilisateur

        //vérification de la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            //hacher le mot de passe , on récupère le mot de passe et on le hache 
            //création d'une variable qui va contenir le mot de passe haché $password
            $password = $form->get('password')->getData();
            $passwordHached = $userPasswordHasherInterface->hashPassword($user, $password);
            //mettre l'objet user dans la base de données
            $user->setPassword($passwordHached);
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();
            //persist et flush méthodes liée à la doctrine pour insérer à la bdd
            //une fois que notre formulaire est soumis et validé, on redirige l'utilisateur vers la page de connexion
            return $this->redirectToRoute('app_login');
        }


        return $this->render('register/register.html.twig', [
            //afficher le formulaire d'inscription
            'formInscription' => $form->createView(),
        ]);
    }
}
