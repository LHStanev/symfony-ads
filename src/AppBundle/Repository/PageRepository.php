<?php

namespace AppBundle\Repository;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends \Doctrine\ORM\EntityRepository
{
    public function showLastFive()
    {
        $em     = $this->getEntityManager();
        $query  = $em->createQuery("SELECT p FROM AppBundle:Page p
                                          ORDER BY p.id DESC ");
        $query->setMaxResults(5);

        $result = $query->getResult();
        return $result;
    }
}