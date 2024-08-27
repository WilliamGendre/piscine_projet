<?php

namespace App\Controller\publicController;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController{

    #[Route('/insert', name: 'user_insert')]
    public function insertUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher){
        if ($request->getMethod() === 'POST') {

            $name = $request->request->get('name');
            $firstname = $request->request->get('firstname');
            $pseudo = $request->request->get('pseudo');
            $bornAt = $request->request->get('bornAt');
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            if(!$name){
                $this->addFlash('fail', 'Il manque le nom');
                return $this->render('publicView/page/user/insertUser.html.twig');
            }

            if(!$firstname){
                $this->addFlash('fail', 'Il manque le prénom');
                return $this->render('publicView/page/user/insertUser.html.twig');
            }

            if(!$bornAt){
                $this->addFlash('fail', 'Il manque le prénom');
                return $this->render('publicView/page/user/insertUser.html.twig');
            }

            // Empêche de créer un user sans email

            if(!$email){
                $this->addFlash('fail', 'Il manque l\'adresse mail');
                return $this->render('publicView/page/user/insertUser.html.twig');
            }

            // Empêche de créer un user sans mot de passe

            if(!$password){
                $this->addFlash('fail', 'Il manque le mot de passe');
                return $this->render('publicView/page/user/insertUser.html.twig');
            }

            // Créer un user

            $user = new User();


                $hashedPassword = $passwordHasher->hashPassword($user, $password);
                $bornAtDate = new \DateTime($bornAt);

                $user->setEmail($email);
                $user->setRoles(['ROLE_USER']);
                $user->setPassword($hashedPassword);
                $user->setName($name);
                $user->setFirstname($firstname);
                $user->setPseudo($pseudo);
                $user->setBornAt($bornAtDate);

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'L\'utilisateur à bien été créé');

        }

        return $this->render('publicView/page/user/insertUser.html.twig');
    }


}