<?php

namespace KG\BeekeepingManagementBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * TranshumanceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TranshumanceRepository extends EntityRepository
{
    public function getListByColonie($colonie)
    {
        $q = $this->createQueryBuilder('t')
                  ->leftJoin('t.colonie','colonie')
                  ->addSelect('colonie')
                  ->where('colonie.id = :id')
                  ->setParameter('id',$colonie->getId());
        
        $q->setFirstResult(($page-1)*$maxperpage)
          ->setMaxResults($maxperpage);
        
        return new Paginator($q);
    }   
}
