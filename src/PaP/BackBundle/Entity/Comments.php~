<?php

namespace PaP\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Comments
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="PaP\BackBundle\Repository\CommentsRepository")
 */
class Comments
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @Assert\Length(
     *    min = 2,
     *    minMessage = "Your first name must be at least {{ limit }} characters long",
     *)
     *
     * @Assert\NotBlank() (message="Must not be empty")
     *
     * @ORM\Column(name="user", type="string", length=100)
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank() (message="Must not be empty")
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;

    /**
     * @var integer
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      maxMessage = "The higher mark must be 5"
     * )
     *
     * @ORM\Column(name="mark", type="integer")
     */
    private $mark;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activate", type="boolean")
     */
    private $activate;

    /**
     * @ORM\ManyToOne(targetEntity="Announcement", inversedBy="comments")
     * @ORM\JoinColumn(name="announcement_id", referencedColumnName="id", nullable=false)
     */
    private $announcement;



    public function __construct()
    {
        $this->dateCreated= new \DateTime("now");
        $this->activate=false;


    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comments
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Comments
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Comments
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set mark
     *
     * @param integer $mark
     *
     * @return Comments
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return integer
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set activate
     *
     * @param boolean $activate
     *
     * @return Comments
     */
    public function setActivate($activate)
    {
        $this->activate = $activate;

        return $this;
    }

    /**
     * Get activate
     *
     * @return boolean
     */
    public function getActivate()
    {
        return $this->activate;
    }

    /**
     * Set announcement
     *
     * @param \PaP\BackBundle\Entity\Announcement $announcement
     *
     * @return Comments
     */
    public function setAnnouncement(\PaP\BackBundle\Entity\Announcement $announcement)
    {
        $this->announcement = $announcement;

        return $this;
    }

    /**
     * Get announcement
     *
     * @return \PaP\BackBundle\Entity\Announcement
     */
    public function getAnnouncement()
    {
        return $this->announcement;
    }
}
