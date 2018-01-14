<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use AppBundle\Form\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends Controller
{
    /**
     * @Route("/page/{slug}", name="single_page")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showSinglePageAction(string $slug)
    {
        $page = $this->getDoctrine()->getRepository(Page::class)->findOneBy(['slug' => $slug]);

        return $this->render('page/single_page.html.twig', ['page' => $page]);
    }

    /**
     * @Route("/pages/create", name="create_page")
     * @param Request $request
     */
    public function createAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $file = $page->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $page->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('page/create.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/pages/edit/{id}", name="edit_page")
     * @param Request $request
     */
    public function editAction(Request $request, int $id)
    {
        $page = $this->getDoctrine()->getRepository(Page::class)->find($id);
        $form = $this->createForm(PageType::class, $page);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $file = $page->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $page->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('page/edit.html.twig', ['form' => $form->createView()]);

    }
}
