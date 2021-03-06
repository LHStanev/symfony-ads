<?php

namespace AppBundle\Repository;

/**
 * AdRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdRepository extends \Doctrine\ORM\EntityRepository
{
    public function showLastTen()
    {
        $em     = $this->getEntityManager();
        $query  = $em->createQuery("SELECT a FROM AppBundle:Ad a
                                LEFT JOIN a.category c
                                  LEFT JOIN a.location l
                                    ORDER BY a.id DESC ");
        $query->setMaxResults(10);

        $result = $query->getResult();

        return $result;
    }

    public function showByCategory(string $categorySlug)
    {
        $em     = $this->getEntityManager();
        $query  = $em->createQuery("SELECT a FROM AppBundle:Ad a
                                LEFT JOIN a.category c
                                  LEFT JOIN a.location l
                                    WHERE c.slug = :slug
                                      ORDER BY a.id DESC ");
        $query->setParameter('slug', $categorySlug);
        $result = $query->getResult();

        return $result;
    }
}
