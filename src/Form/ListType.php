<?php

namespace App\Form;

use App\Entity\TodoList;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ListType extends TodoType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TodoList::class,
        ]);
    }
}
