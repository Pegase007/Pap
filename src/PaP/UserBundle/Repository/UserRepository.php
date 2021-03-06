<?php

namespace PaP\UserBundle\Repository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository implements UserProviderInterface
{

    /**
     * @param $username
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return User|null
     */
    public function loadUserByUsername($loginOrEmail)

    {
         $user= $this->createQueryBuilder('u')
            ->andWhere('u.username = :username OR u.email = :email')
            ->setParameters([
                'username' => $loginOrEmail,
                'email' => $loginOrEmail
            ])
            ->getQuery()
            ->getOneOrNullResult();
        if(null == $user)
        {

//            $message = sprintd(
//                'Impossible de trouver un utilisateur avec le login ou le mot de passe suivant "%u',
//                $loginOrEmail
            //OU
            $message = 'Impossible de trouver un utilisateur avec le login ou le mot de passe suivant: '.$loginOrEmail;

//            );
            throw new UsernameNotFoundException($message);
        }
        return $user;

    }


    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user); // $class Troiswa\BackBundle\Entity\User
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

//        return $this->find($user->getId());
//        cette écriture permet de faire du lazyloading au niveau de user

        return $this->loadUserByUsername($user->getUsername());
    }


    public function supportsClass($class)
    {

        return $this->getEntityName() ===$class
            || is_subclass_of($class, $this->getEntityName());

    }




}
