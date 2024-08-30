<?php

declare(strict_types=1);

namespace App\Controller\userController;

use App\Repository\IllustrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserHome extends AbstractController{

    #[Route('/user', name:'user_home')]
    public function userHome(IllustrationRepository $illustrationsRepository){
        $currentUser = $this->getUser();
        $illustrations = [];
        foreach ($illustrationsRepository->findAll() as $illustration){
            if($illustration->getUser() === $currentUser){
                $illustrations[] = $illustration;
            }
        }

        return $this->render('user/page/userHome.html.twig', ['illustrations' => $illustrations, 'user' => $currentUser]);
    }

    #[Route('/user/updateUser', name:'update_user')]
    public function updateUser(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();

        if ($request->getMethod() === 'POST'){

            $name = $request->request->get('name');
            $firstname = $request->request->get('firstname');
            $pseudo = $request->request->get('pseudo');

            if(!$name){
                $this->addFlash('fail', 'Il manque le nom');
                return $this->render('publicView/page/user/insertUser.html.twig');
            }

            if(!$firstname){
                $this->addFlash('fail', 'Il manque le prénom');
                return $this->render('publicView/page/user/insertUser.html.twig');
            }


            $user->setName($name);
            $user->setFirstname($firstname);
            $user->setPseudo($pseudo);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Le profil à bien été modifié');
        }

        return $this->render('user/page/userUpdate.html.twig', ['user' => $user]);
    }

    #[Route('/user/deleteUser', name:'delete_user')]
    public function userDelete(EntityManagerInterface $entityManager){
        $currentUser = $this->getUser();

        $entityManager->remove($currentUser);
        $entityManager->flush();

        $this->addFlash('success', 'Le profil à bien été supprimé');

        return $this->redirectToRoute('index');
    }
}