<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use DateTimeImmutable;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/category', 'admin_category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index()
    {
        return $this->render('admin/category/index.html.twig');
    }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $em)
    {
        $category = new Category();
        $category->setNom('bonbons')
            ->setDescription('Meilleurs bonbons du monde')
            ->setCreateAt(new \DateTimeImmutable());

        $em->persist($category);
        $em->flush();

        return $this->render('admin/category/create.html.twig');
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS])]
    public function update(Category $category, EntityManagerInterface $em)
    {
        $category->setNom('Bonbons')
        ->setUpdateAt(new \DateTimeImmutable());

        $em->flush();

        return $this->render('admin/category/update.html.twig');
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete(EntityManagerInterface $em, Category $category)
    {
        $em->remove($category);

        $em->flush();

        return $this->render('admin/category/delete.html.twig');
    }
}
