<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use DateTimeImmutable;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/category', 'admin_category_')]
class CategoryController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'index')]
    public function index(CategoryRepository $repository)
    {
        $categories = $repository->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create()
    {
        $category = new Category();
        $category->setNom('bonbons')
            ->setDescription('Meilleurs bonbons du monde')
            ->setCreateAt(new \DateTimeImmutable());

        $this->em->persist($category);
        $this->em->flush();

        return $this->render('admin/category/create.html.twig');
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS])]
    public function update(Category $category, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/update.html.twig', [
            'formCategory' => $form
        ]);
        // $category->setNom('Bonbons')
        // ->setUpdateAt(new \DateTimeImmutable());

        // $em->flush();

        return $this->render('admin/category/update.html.twig');
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete(Category $category)
    {
        $this->em->remove($category);

        $this->em->flush();

        return $this->render('admin/category/delete.html.twig');
    }
}
