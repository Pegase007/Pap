<?php

namespace PaP\BackBundle\Repository;

/**
 * CommentsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentsRepository extends \Doctrine\ORM\EntityRepository
{

    public function lastComments($id)
    {
        $query = $this->createQueryBuilder("com")
            ->where ('com.announcement = :id')
            ->setParameters(["id"=>$id])
            ->orderBy('com.dateCreated','desc')
            ->setMaxResults(5)
            ->getQuery();

        return $query->getResult();
    }

    public function lastComs()
    {
        $query = $this->createQueryBuilder("com")
            ->orderBy('com.dateCreated','desc')
            ->setMaxResults(10)
            ->getQuery();

        return $query->getResult();
    }
}
