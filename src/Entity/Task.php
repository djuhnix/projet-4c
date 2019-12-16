<?php

namespace App\Entity;

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
     * @var TodoList
     *
     * @ORM\ManyToOne(targetEntity="TodoList")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="list", referencedColumnName="id_list")
     * })
     */
    private $list;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id_user")
     * })
     */
    private $user;


}
