<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ad;
use AppBundle\Entity\Category;
use AppBundle\Entity\Location;
use AppBundle\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin/index", name="admin_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $pages      = $this->getDoctrine()->getRepository(Page::class)->showLastFive();
        $categories = $this->getDoctrine()->getRepository(Category::class)->showLastFive();
        $locations  = $this->getDoctrine()->getRepository(Location::class)->showLastFive();
        $ads        = $this->getDoctrine()->getRepository(Ad::class)->showLastTen();

        return $this->render('admin/index.html.twig', [
            'pages'         => $pages,
            'categories'    => $categories,
            'locations'     =>$locations,
            'ads'           =>$ads]);
    }
}