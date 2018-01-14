<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Location;
use AppBundle\Form\LocationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends Controller
{
    /**
     * @Route("/locations/create", name="create_location")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            return $this->redirectToRoute('admin_index');

        }

        return $this->render('location/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/locations/edit/{id}", name="edit_location")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, int $id)
    {
        $location = $this->getDoctrine()->getRepository(Location::class)->find($id);
        $form = $this->createForm(LocationType::class, $location);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('admin_index');

        }

        return $this->render('location/create.html.twig', ['form' => $form->createView()]);
    }
}
