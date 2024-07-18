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
use Symfony\Component\HttpFoundation\Response;

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
    public function create(Request $request,EntityManagerInterface $em):Response
    {
        $categorie = new Category();
        $form = $this->createForm(CategoryType::class,$categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $categorie->setCreateAt(new DateTimeImmutable());
           $em->persist($categorie);
           $em->flush();

           $this->addFlash('success','Une nouvelle catégorie a été ajouté !');
        }

        return $this->render('admin/category/create.html.twig',['formCategorie' => $form]);
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

    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete(Category $category)
    {
        $this->em->remove($category);

        $this->em->flush();

        return $this->render('admin/category/delete.html.twig');
    }
}
