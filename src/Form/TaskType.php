<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TaskType extends TodoType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
