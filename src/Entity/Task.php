<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Task.
 *
 * @ORM\Table(name="task", indexes={@ORM\Index(name="fk_task_user1_idx", columns={"user"}), @ORM\Index(name="fk_task_list_idx", columns={"todo_list"})})
 * @ORM\Entity
 */
class Task
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_task", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="taskname", type="string", length=45, nullable=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="createDate", type="datetime", nullable=false)
     * @Assert\Type("\DateTime")
     */
    private $createdate;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="dueDate", type="datetime", nullable=true)
     * @Assert\Type("\DateTime")
     * @Assert\Expression(
     *     "value >= this.getCreatedate()",
     *     message="Due date must be later than the create date (now)"
     * )
     */
    private $duedate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=500, nullable=true)
     */
    private $description;
    /**
     * @var bool|null
     *
     * @ORM\Column(name="done", type="boolean", nullable=true)
     */
    private $done = 0;

    /**
     * @var TodoList
     *
     * @ORM\ManyToOne(targetEntity="TodoList", inversedBy="tasks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="todo_list", referencedColumnName="id_list", onDelete="CASCADE")
     * })
     * @Assert\Type("\App\Entity\TodoList")
     */
    private $todoList;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id_user")
     * })
     * @Assert\Type("App\Entity\User")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedate(): ?\DateTimeInterface
    {
        return $this->createdate;
    }

    public function setCreatedate(\DateTimeInterface $createdate): self
    {
        $this->createdate = $createdate;

        return $this;
    }

    public function getDuedate(): ?\DateTimeInterface
    {
        return $this->duedate;
    }

    public function setDuedate(?\DateTimeInterface $duedate): self
    {
        $this->duedate = $duedate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTodoList(): ?TodoList
    {
        return $this->todoList;
    }

    public function setTodoList(?TodoList $todoList): self
    {
        $this->todoList = $todoList;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isDone(): ?string
    {
        return $this->done;
    }

    public function setDone(?string $done): self
    {
        $this->done = $done;

        return $this;
    }

    public function getDone(): ?bool
    {
        return $this->done;
    }
}
