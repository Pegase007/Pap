<?php

namespace PaP\BackBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use \PaP\BackBundle\Entity;

/**
 * Announcement
 *
 * @ORM\Table(name="announcement")
 * @ORM\Entity(repositoryClass="PaP\BackBundle\Repository\AnnouncementRepository")
 *
 * @UniqueEntity("title")
 * @UniqueEntity("ref")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Announcement
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
     *   * @Assert\Length(
     *    min = 10,
     *    minMessage = "Your first name must be at least {{ limit }} characters long",
     *)
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=100)
     */
    protected $title;

    /**
     * @var float
     *
     *    * @Assert\Regex(
     *     pattern="/^[0-9]{1,}(.)?[0-9]{1,2}$/",
     *     message="The value {{ value }} is not a valid price."
     * )
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="price", type="integer")
     */
    protected $price;


    /**
     * @var boolean
     *
     * @ORM\Column(name="photo", type="string")
     */
    protected $photo;

    /**
     * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 400,
     *     minHeight = 200,
     *     maxHeight = 400
     * )
     */
    private $file;



    /**
     * @var string
     *
     * * @Assert\Regex(
     *     pattern="/^(REF-)[0-9]{1,}$/",
     *     message="The value {{ value }} is not a valid reference."
     * )
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="ref", type="string", length=100)
     */
    protected $ref;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="address", type="string", length=255)
     */
    protected $address;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="city", type="string", length=100)
     */
    protected $city;

    /**
     * @var integer
     *
     * @Assert\Type(
     *   type="integer",
     *   message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\Length(
     *    min = 5,
     *    max=5,
     *    minMessage = "Your cp must  {{ limit }} characters long",
     *    maxMessage = "Your cp must  {{ limit }} characters long",
     *)
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="cp", type="integer")
     */
    protected $cp;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="country", type="string", length=100)
     */
    protected $country;

    /**
     * @var string
     * @Assert\Choice(choices = {"hs", "apt"}, message = "Choose a valid type.")
     * @ORM\Column(name="type", type="string", length=100, nullable=false)
     */
    protected $type;

    /**
     * @var string
     *
     * @Assert\Length(
     *    max = 1,
     *    minMessage = "Your energyLabel must {{ limit }} letter long",
     *)
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="energyLabel", type="string", length=100)
     */
    protected $energyLabel;

    /**
     * @var integer
     *
     *@Assert\NotBlank()
     * @ORM\Column(name="surface", type="integer")
     */
    protected $surface;

    /**
     * @var integer
     *
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="nbRooms", type="integer")
     */
    protected $nbrooms;

    /**
     * @var integer
     *
     *  * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     *
     *@Assert\NotBlank()
     * @ORM\Column(name="bedrooms", type="integer")
     */
    protected $bedrooms;

    /**
     * @var integer
     *
     * @ORM\Column(name="pricePerMeterSquare", type="integer", nullable=true)
     */
    protected $pricePerMeterSquare;



    /**
     * @var string
     *
     *    * * @Assert\Length(
     *      max = 1500,
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *
     * )
     * @Assert\NotBlank()
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activate", type="boolean")
     */
    protected $activate;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(type="datetime", nullable = true, name="updated_at")
     */
    protected $updatedAt;



    /**
     * @Assert\NotBlank(message="Please choose a user")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id", nullable=false)
     *
     */
    protected $user;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Options", inversedBy="announcement",cascade={"persist"})
     * @ORM\JoinTable(name="Announcement_Options")
     */
    protected $options;




    public function __construct()
    {

        $this->photo = new ArrayCollection();
        $this->options = new ArrayCollection();


    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();

    }


    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
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
     * Set title
     *
     * @param string $title
     *
     * @return Announcement
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Announcement
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set ref
     *
     * @param string $ref
     *
     * @return Announcement
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Announcement
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Announcement
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     *
     * @return Announcement
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Announcement
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Announcement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set energyLabel
     *
     * @param string $energyLabel
     *
     * @return Announcement
     */
    public function setEnergyLabel($energyLabel)
    {
        $this->energyLabel = $energyLabel;

        return $this;
    }

    /**
     * Get energyLabel
     *
     * @return string
     */
    public function getEnergyLabel()
    {
        return $this->energyLabel;
    }

    /**
     * Set surface
     *
     * @param integer $surface
     *
     * @return Announcement
     */
    public function setSurface($surface)
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * Get surface
     *
     * @return integer
     */
    public function getSurface()
    {
        return $this->surface;
    }

    /**
     * Set nbrooms
     *
     * @param integer $nbrooms
     *
     * @return Announcement
     */
    public function setNbrooms($nbrooms)
    {
        $this->nbrooms = $nbrooms;

        return $this;
    }

    /**
     * Get nbrooms
     *
     * @return integer
     */
    public function getNbrooms()
    {
        return $this->nbrooms;
    }

    /**
     * Set bedrooms
     *
     * @param integer $bedrooms
     *
     * @return Announcement
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    /**
     * Get bedrooms
     *
     * @return integer
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * Set pricePerMeterSquare
     *
     * @param integer $pricePerMeterSquare
     *
     * @return Announcement
     */
    public function setPricePerMeterSquare($pricePerMeterSquare)
    {
        $this->pricePerMeterSquare = $pricePerMeterSquare;

        return $this;
    }

    /**
     * Get pricePerMeterSquare
     *
     * @return integer
     */
    public function getPricePerMeterSquare()
    {
        return $this->pricePerMeterSquare;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Announcement
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Announcement
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Announcement
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add photo
     *
     * @param \PaP\BackBundle\Entity\Photo $photo
     *
     * @return Announcement
     */
    public function addPhoto(Photo $photo)
    {
        $this->photo[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \PaP\BackBundle\Entity\Photo $photo
     */
    public function removePhoto(Photo $photo)
    {
        $this->photo->removeElement($photo);
    }

    /**
     * Set image
     *
     * @param \PaP\BackBundle\Entity\Photo $photo
     *
     * @return Announcement
     */
    public function setPhoto($photo= null)
    {

        $this->photo = $photo;

        return $this;
    }





    /**
     * Get photo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set user
     *
     * @param \PaP\BackBundle\Entity\User $user
     *
     * @return Announcement
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \PaP\BackBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add option
     *
     * @param \PaP\BackBundle\Entity\Options $option
     *
     * @return Announcement
     */
    public function addOption(Options $option)
    {
        $this->options[] = $option;

        return $this;
    }

    /**
     * Remove option
     *
     * @param \PaP\BackBundle\Entity\Options $option
     */
    public function removeOption(Options $option)
    {
        $this->options->removeElement($option);
    }

    /**
     * Get options
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set activate
     *
     * @param boolean $activate
     *
     * @return Announcement
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




    public function getAbsolutePath()
    {
        return null === $this->photo
            ? null
            : $this->getUploadRootDir().'/'.$this->photo;
    }

    public function getWebPath()
    {
        return null === $this->photo
            ? null
            : $this->getUploadDir().'/'.$this->photo;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/announcement';
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->photo = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
}
