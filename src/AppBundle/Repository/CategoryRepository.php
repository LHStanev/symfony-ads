<?php

namespace AppBundle\Repository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function showLastFive()
    {
        $em     = $this->getEntityManager();
        $query  = $em->createQuery("SELECT c FROM AppBundle:Category c
                                          ORDER BY c.id DESC ");
        $query->setMaxResults(5);

        $result = $query->getResult();
        return $result;
    }
}
