<?php

declare(strict_types=1);

namespace App\Controller\adminController;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class AdminHomeController extends AbstractController{

    #[Route('/admin', 'index_admin')]
    public function indexAdmin(UserRepository $userRepository){

        $users = [];
        foreach ($userRepository->findAll() as $user){
            if(!in_array("ROLE_ADMIN", $user->getRoles(), true)){
                $users[] = $user;
            }
        }

        return $this->render('admin/indexAdmin.html.twig', ['users' => $users]);
    }
}