<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PullRequestRepository")
 */
class PullRequest
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $from_uid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $to_uid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromUid(): ?string
    {
        return $this->from_uid;
    }

    public function setFromUid(?string $from_uid): self
    {
        $this->from_uid = $from_uid;

        return $this;
    }

    public function getToUid(): ?string
    {
        return $this->to_uid;
    }

    public function setToUid(?string $to_uid): self
    {
        $this->to_uid = $to_uid;

        return $this;
    }
}
