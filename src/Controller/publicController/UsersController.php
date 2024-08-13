<?php

namespace App\Controller\publicController;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UsersController extends AbstractController{

    #[Route('/insert', name: 'users_insert')]
    public function insertUsers(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher){
        if ($request->getMethod() === 'POST') {

            $name = $request->request->get('name');
            $firstname = $request->request->get('firstname');
            //$bornAt = $request->request->get('bornAt');
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // Empêche de créer un user sans email

            if(!$email){
                $this->addFlash('success', 'Il manque l\'adresse mail');
                return $this->render('publicView/page/users/insertUser.html.twig');
            }

            // Empêche de créer un user sans mot de passe

            if(!$password){
                $this->addFlash('success', 'Il manque le mot de passe');
                return $this->render('publicView/page/users/insertUser.html.twig');
            }

            // Créer un user

            $user = new Users();

//            try {

                // Permet de hacher le mot de passe pour plus de sécurité

                $hashedPassword = $passwordHasher->hashPassword($user, $password);

                $user->setEmail($email);
                $user->setRoles(['ROLE_USER']);
                $user->setPassword($hashedPassword);
                $user->setName($name);
                $user->setFirstname($firstname);
                //$user->setBornAt($bornAt ->format('Y-m-d'));

                $entityManager->persist($user);
//                dd($user);
                $entityManager->flush();

                $this->addFlash('success', 'L\'utilisateur à bien été créé');

//            } catch (\Exception $exception ) {

//                $this->addFlash('error', $exception->getMessage());

//            }


        }

        return $this->render('publicView/page/users/insertUser.html.twig');
    }


}