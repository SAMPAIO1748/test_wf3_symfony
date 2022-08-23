<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez remplir le titre de l'article")
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "Votre titre doit faire 5 caractères minimum"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, inversedBy="articles")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $tag;

    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="article")
     */
    private $medias;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->setArticle($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getArticle() === $this) {
                $media->setArticle(null);
            }
        }

        return $this;
    }
}

/**
 * Créer les entités Category (name[string, 255, non nullable], description[text, non nullable]), 
 * Tag(name[string, 255, non nullable], description[text, non nullable], color[string, 255, non nullable])
 * 
 * 
 * Nouvel exercice : Relier la table article et tag. Un article aura un tag et un tag aura plusieurs articles.
 */
