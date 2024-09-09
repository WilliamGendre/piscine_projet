<?php

declare(strict_types=1);

namespace App\Controller\adminController;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdminCategoryController extends AbstractController{

    #[Route('admin/category', name: 'admin_category')]
    public function adminCategory(CategoryRepository $categoryRepository){
        return $this->render('admin/page/listeCategory.html.twig',
            ['categorys' => $categoryRepository->findAll()]);
    }

    #[Route('/admin/insertCategory', name: 'admin_insert_category')]
    public function insertCategory(Request $request, EntityManagerInterface $entityManager){

        $category = new Category();
        if($request->getMethod() === 'POST'){
            $libelle = $request->request->get('libelle');

            if(!$libelle){
                $this->addFlash('fail', 'Il manque le nom de la catégorie');
                return $this->render('admin/page/insertCategory.html.twig');
            }

            $category->setLibelle($libelle);

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a bien été créé');
        }

        return $this->render('admin/page/insertCategory.html.twig');
    }

    #[Route('/admin/updateCategory/{id}', name: 'admin_update_category')]
    public function updateCategory(int $id, CategoryRepository $categoryRepository, Request $request,
                                   EntityManagerInterface $entityManager){
        $category = $categoryRepository->find($id);

        if (!$category) {
            return $this->render('admin/error404Admin.html.twig');
        }

        if($request->getMethod() === 'POST'){
            $libelle = $request->request->get('libelle');

            $category->setLibelle($libelle);

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a bien été modifié');

            return $this->redirectToRoute('admin_category', ['id' => $id]);
        }

        return $this->render('admin/page/updateCategory.html.twig', ['category' => $category]);
    }

    #[Route('/admin/deleteCategory/{id}', name: 'admin_delete_category')]
    public function deleteCategory(int $id, CategoryRepository $categoryRepository,
                                   EntityManagerInterface $entityManager){
        $category = $categoryRepository->find($id);

        if (!$category) {
            return $this->render('admin/error404Admin.html.twig');
        }

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('admin_category', ['category' => $category->getId()]);
    }
}