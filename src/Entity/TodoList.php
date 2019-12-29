<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TodoList.
 *
 * @ORM\Table(name="todo_list", indexes={@ORM\Index(name="fk_list_user1_idx", columns={"user"})})
 * @ORM\Entity(repositoryClass="App\Repository\ListRepository")
 */
class TodoList
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_list", type="integer", nullable=false, options={"comment"="	"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="listname", type="string", length=45, nullable=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="createDate", type="date", nullable=false)
     *
     * @Assert\Type("\DateTime")
     */
    private $createdate;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="dueDate", type="date", nullable=true)
     *
     * @Assert\Type("\DateTime")
     * @Assert\Expression(
     *     "value >= this.getCreatedate()",
     *     message="Due date must be later than the create date"
     * )
     */
    private $duedate = null;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="lists")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id_user")
     * })
     */
    private $user;
    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Task", mappedBy="todoList")
     * @ORM\OrderBy({"duedate" = "DESC"})
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setTodoList($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getTodoList() === $this) {
                $task->setTodoList(null);
            }
        }

        return $this;
    }
}
