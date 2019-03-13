<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;

/**
 * Tasks
 *
 * @ORM\Table(name="tasks", indexes={@ORM\Index(name="fk_tasks_users_idx", columns={"user_id"})})
 * @ORM\Entity
 * @Entity @HasLifecycleCallbacks
 */
class Task
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="content", type="text", length=0, nullable=true)
     */
    private $content;

    /**
     * @var string|null
     *
     * @ORM\Column(name="priority", type="string", length=45, nullable=true)
     */
    private $priority;

    /**
     * @var int|null
     *
     * @ORM\Column(name="hours", type="integer", nullable=true)
     */
    private $hours;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /** @PrePersist */
    public function doOnPrePersist()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ? int
    {
        return $this->id;
    }

    public function getTitle(): ? string
    {
        return $this->title;
    }

    public function setTitle(? string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ? string
    {
        return $this->content;
    }

    public function setContent(? string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPriority(): ? string
    {
        return $this->priority;
    }

    public function setPriority(? string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getHours(): ? int
    {
        return $this->hours;
    }

    public function setHours(? int $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getCreatedAt(): ? \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(? \DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ? User
    {
        return $this->user;
    }

    public function setUser(? User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
