<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ad;
use AppBundle\Entity\Category;
use AppBundle\Form\AdType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends Controller
{
    /**
     * @param int $id
     * @Route("ads/show/{id}", name="single_ad")
     */
    public function showSingleAdAction(int $id)
    {
        $ad = $this->getDoctrine()->getRepository(Ad::class)->find($id);
        $ad->addView();
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->render('ad/single_ad.html.twig', ['ad' => $ad]);
    }

    /**
     * @Route("ads/create", name="create_ad")
     */
    public function createAdAction(Request $request)
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $image = $ad->getImage();

            $imageName = md5(uniqid()).'.'.$image->guessExtension();

            $image->move(
                $this->getParameter('images_directory'),
                $imageName
            );

            $ad->setImage($imageName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($ad);
            $em->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('ad/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("ads/edit/{id}", name="edit_ad")
     * @param Request $request
     * @param int $id
     */
    public function EditAdAction(Request $request, int $id)
    {
        $ad = $this->getDoctrine()->getRepository(Ad::class)->find($id);
        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $image = $ad->getImage();

            $imageName = md5(uniqid()).'.'.$image->guessExtension();

            $image->move(
                $this->getParameter('images_directory'),
                $imageName
            );

            $ad->setImage($imageName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($ad);
            $em->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('ad/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/ads/category/{name}", name="ads_by_category")
     */
    public function showByCategory(string $name)
    {
        $ads = $this->getDoctrine()->getRepository(Ad::class)->showByCategory($name);
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['slug' => $name]);
        $categoryName = $category->getName();

        return $this->render("ad/by_category.html.twig", ['ads' => $ads, 'categoryName' => $categoryName]);
    }
}
