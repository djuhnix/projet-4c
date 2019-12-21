<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task", indexes={@ORM\Index(name="fk_task_user1_idx", columns={"user"}), @ORM\Index(name="fk_task_list_idx", columns={"list"})})
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
    private $idTask;

    /**
     * @var string|null
     *
     * @ORM\Column(name="taskname", type="string", length=45, nullable=true)
     */
    private $taskname;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="createDate", type="date", nullable=false)
     */
    private $createdate;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="dueDate", type="date", nullable=true)
     */
    private $duedate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @var TodoList
     *
     * @ORM\ManyToOne(targetEntity="TodoList", inversedBy="tasks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="todo_list", referencedColumnName="id_list")
     * })
     */
    private $todoList;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id_user")
     * })
     */
    private $user;

    public function getIdTask(): ?int
    {
        return $this->idTask;
    }

    public function getTaskname(): ?string
    {
        return $this->taskname;
    }

    public function setTaskname(?string $taskname): self
    {
        $this->taskname = $taskname;

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


}
