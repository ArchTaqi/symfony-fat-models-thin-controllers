<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tbl_bad_words")
 * @ORM\Entity(repositoryClass="App\Repository\BadWordRepository")
 */
class BadWord
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private $word;

    ######################################
    ######     Getters Setters      ######
    ######################################

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }
    public function setWord(string $word): self
    {
        $this->word = $word;
        return $this;
    }

    ######################################
    ###  Constructor & Other Methods   ###
    ######################################

    /**
     * @return null|string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getWord();
    }
}
