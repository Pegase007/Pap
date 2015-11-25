<?php

namespace PaP\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="PaP\BackBundle\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="fath", type="string", length=255)
     */
    protected $path;

    /**
     *
     * @Assert\Image(
     *     allowLandscape = true,
     *     allowPortrait = true,
     *
     *     maxSize = "2000k",
     *     mimeTypes = {"image/jpeg", "image/png","image/gif"},
     *     mimeTypesMessage = "Please upload a valid image jpeg,png or gif format"

     * )
     *
     */
    protected $file;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateAt", type="datetime", nullable=true)
     */
    protected $updatedAt;

}
