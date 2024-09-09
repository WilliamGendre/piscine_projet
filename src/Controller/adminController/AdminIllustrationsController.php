<?php

declare(strict_types=1);

namespace App\Controller\adminController;

use App\Repository\IllustrationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class AdminIllustrationsController extends AbstractController
{

    #[Route('/admin/illustrations', name: 'admin_illustrations')]
    public function AdminViewIllustrations(IllustrationRepository $illustrationRepository)
    {
        return $this->render('admin/page/illustrationsAll.html.twig', ['illustrations' => $illustrations = $illustrationRepository->findAll()]);
    }

    #[Route('admin/deleteIllustration/{id}', name: 'admin_deleteIllustration')]
    public function deleteUser(int $id, IllustrationRepository $illustrationRepository, EntityManagerInterface $entityManager)
    {
        $illustration = $illustrationRepository->find($id);

        if (!$illustration) {
            return $this->render('admin/error404Admin.html.twig');
        }

        $entityManager->remove($illustration);
        $entityManager->flush();

        return $this->redirectToRoute('admin_illustrations', ['illustration' => $illustration->getId()]);
    }
}