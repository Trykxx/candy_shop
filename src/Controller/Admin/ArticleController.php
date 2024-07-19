<?php

namespace App\Controller\Admin;

use App\Entity\Candy;
use App\Form\CandyType;
use App\Form\CategoryType;
use App\Repository\CandyRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/article', 'admin_article_')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CandyRepository $repository)
    {
        $bonbons = $repository->findAll();

        return $this->render('admin/article/index.html.twig',['bonbons' => $bonbons]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $bonbon = new Candy();
        $form = $this->createForm(CandyType::class,$bonbon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bonbon->setCreateAt(new DateTimeImmutable());

            $slug = $slugger->slug($bonbon->getName())->lower();
            $bonbon->setSlug($slug);

            $em->persist($bonbon);
            $em->flush();

           $this->addFlash('success','Un nouveau bonbon a été ajouté !');

           return $this->redirectToRoute('admin_article_index');
        }
        return $this->render('admin/article/create.html.twig',['formCandy'=>$form]);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS])]
    public function update(Candy $bonbon, Request $request,EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $form = $this->createForm(CandyType::class, $bonbon);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slug = $slugger->slug($bonbon->getName())->lower();
            $bonbon->setSlug($slug);

            $em->flush();
            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('admin/article/update.html.twig',['formBonbon' => $form]);

        // find() permet de récupérer un enregistrement de la basse de données grace a son id.
        // $candy = $repository->find(1);

        // findAll() permet de récupérer tous les enregistrement de la basse de données.
        // $candy = $repository->findAll();

        // findBy() permet de récupérer tous les enregistrement de la basse de données correspondant a des conditions sur les champs
        // $candy = $repository->findBy(['name'=>'Sucette']);

        //  findOneBy() permet de recuperer le premier enregistrement de la base de données correspondant à des conditions sur les champs
        // $candy = $repository->findOneBy(['slug' => 'fraise','name' => 'Sucette']);

        // $candy = $repository->find($id);

        // $candy->setName('fraise');
        // $em->flush();

    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete($id, CandyRepository $repository, EntityManagerInterface $em, Candy $candy)
    {
        // $candy = $repository->find($id);

        $em->remove($candy);

        $em->flush();

        return $this->render('admin/article/delete.html.twig');
    }
}
