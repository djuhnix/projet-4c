<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * List
 *
 * @ORM\Table(name="list", indexes={@ORM\Index(name="fk_list_user1_idx", columns={"user"})})
 * @ORM\Entity
 */
class TodoList
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_list", type="integer", nullable=false, options={"comment"="	"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idList;

    /**
     * @var string|null
     *
     * @ORM\Column(name="listname", type="string", length=45, nullable=true)
     */
    private $listname;

    /**
     * @var User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id_user")
     * })
     */
    private $user;


}
