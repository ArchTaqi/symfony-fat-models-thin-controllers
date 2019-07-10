<?php declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tbl_posts")
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    const STATUS_NEW = 'official';
    const STATUS_READ = 'meetup';

    public static $typesValues = [
        self::STATUS_NEW => self::STATUS_NEW,
        self::STATUS_READ => self::STATUS_READ,
    ];


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Type cannot be blank")
     * @Assert\Length(min=3, minMessage="Type is too short")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=1024)
     * @Assert\NotBlank(message="Please provide title", groups={"PostCreate"})
     * @Assert\Length(
     *     min=3,
     *     max="1024",
     *     minMessage="Title is too short.",
     *     maxMessage="Title is too long",
     *     groups={"PostCreate"}
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text", length=5000)
     */
    private $body;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    ######################################
    ######     Getters Setters      ######
    ######################################

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }
    /**
     * @param string $type
     * @return Post
     */
    public function setType(string $type): self
    {

        if (!in_array($type, array_keys(self::$typesValues))) {
            throw new \InvalidArgumentException(
                sprintf('Invalid value for post.type : %s.', $type)
            );
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    /**
     * @param string $title
     * @return Post
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }
    /**
     * @param string $body
     * @return Post
     */
    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Post
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    ######################################
    ###  Constructor & Other Methods   ###
    ######################################

    /**
     * Post constructor.
     */
    public function __construct()
    {
        return (string) $this->getTitle();
    }
}
