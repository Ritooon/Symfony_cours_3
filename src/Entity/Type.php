<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 * @Vich\Uploadable
 */
class Type
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
	 * @Vich\UploadableField(mapping="images_types", fileNameProperty="image")
	 */
    private $imageFile;

    /**
     * @ORM\OneToMany(targetEntity=Aliment::class, mappedBy="type")
     */
    private $aliment;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    public function __construct()
    {
        $this->aliment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;

		if($this->imageFile instanceof UploadedFile)
		{
			$this->createdAt = new \DateTime('now');
		}

		return $this;
    }

    /**
     * @return Collection|Aliment[]
     */
    public function getAliment(): Collection
    {
        return $this->aliment;
    }

    public function addAliment(Aliment $aliment): self
    {
        if (!$this->aliment->contains($aliment)) {
            $this->aliment[] = $aliment;
            $aliment->setType($this);
        }

        return $this;
    }

    public function removeAliment(Aliment $aliment): self
    {
        if ($this->aliment->removeElement($aliment)) {
            // set the owning side to null (unless already changed)
            if ($aliment->getType() === $this) {
                $aliment->setType(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
