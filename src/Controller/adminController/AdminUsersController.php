<?php

declare(strict_types=1);

namespace App\Controller\adminController;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdminUsersController extends AbstractController
{

    #[Route('admin/deleteUser/{id}', name: 'admin_deleteUser')]
    public function deleteUser(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager){
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->render('admin/error404Admin.html.twig');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('index_admin', ['user' => $user->getId()]);
    }
}