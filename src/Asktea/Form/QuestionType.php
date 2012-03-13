<?php

namespace Asktea\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Symfony\Component\Validator\Constraints;


class QuestionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('author', 'text')
            ->add('title', 'text')
            ->add('body', 'textarea');
    }

    public function getDefaultOptions(array $options)
    {
        // Collection Constraint
        $collectionConstraint = new Constraints\Collection(array(
            'fields' => array(
                'author' => array(
                    new Constraints\NotNull(),
                    new Constraints\MaxLength(array('limit' => 255))),
                'title' => array(
                    new Constraints\NotNull(),
                    new Constraints\MaxLength(array('limit' => 255))),
                'body' => array(
                    new Constraints\NotNull(),
                    new Constraints\MaxLength(array('limit' => 255))),
            ),
            'allowExtraFields' => false,
        ));

        return array(
            'validation_constraint' => $collectionConstraint,
        );
    }

    public function getName()
    {
        return 'question';
    }
}
