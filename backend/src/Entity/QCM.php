<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Repository\QCMRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QCMRepository::class)]
#[ORM\Table(name: '`qcm`')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['qcm:read']],
    denormalizationContext: ['groups' => ['qcm:write']]
)]
class QCM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $nom = null;

    /**
     * @var Collection<int, Response>
     */
    #[ORM\OneToMany(targetEntity: Response::class, mappedBy: 'qcm', orphanRemoval: true)]
    private Collection $responses;

    /**
     * @var Collection<int, Video>
     */
    #[ORM\OneToMany(targetEntity: Video::class, mappedBy: 'qcm', orphanRemoval: true)]
    private Collection $videos;

    /**
     * @var Collection<int, PDF>
     */
    #[ORM\OneToMany(targetEntity: PDF::class, mappedBy: 'qcm_id', orphanRemoval: true)]
    private Collection $pdfs;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->pdfs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return Collection<int, Response>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): static
    {
        if (!$this->responses->contains($response)) {
            $this->responses->add($response);
            $response->setQcm($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): static
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getQcm() === $this) {
                $response->setQcm(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Video
    {
        return $this->videos;
    }

    public function addVideo(Video $video): static
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setQcm($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): static
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getQcm() === $this) {
                $video->setQcm(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PDF>
     */
    public function getPdfs(): Collection
    {
        return $this->pdfs;
    }

    public function addPdf(PDF $pdf): static
    {
        if (!$this->pdfs->contains($pdf)) {
            $this->pdfs->add($pdf);
            $pdf->setQcm($this);
        }

        return $this;
    }

    public function removePdf(PDF $pdf): static
    {
        if ($this->pdfs->removeElement($pdf)) {
            // set the owning side to null (unless already changed)
            if ($pdf->getQcm() === $this) {
                $pdf->setQcm(null);
            }
        }

        return $this;
    }
}
