<?php

declare(strict_types=1);

namespace App\Controller\adminController;

use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdminCategoryController extends AbstractController{

    #[Route('admin/category', name: 'admin_category')]
    public function adminCategory(CategoryRepository $categoryRepository){
        return $this->render('admin/page/listeCategory.html.twig', ['categorys' => $categoryRepository->findAll()]);
    }

    #[Route('/admin/deleteCategory/{id}', name: 'admin_delete_category')]
    public function deleteCategory(int $id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager){
        $category = $categoryRepository->find($id);

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('admin_category', ['category' => $category->getId()]);
    }
}