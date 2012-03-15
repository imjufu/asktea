<?php

namespace Asktea\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Symfony\Component\Validator\Constraints;


class CommentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Titre'))
            ->add('body', 'textarea', array('label' => 'Réponse'))
            ->add('question_id', 'hidden');
    }

    public function getDefaultOptions(array $options)
    {
        // Collection Constraint
        $collectionConstraint = new Constraints\Collection(array(
            'fields' => array(
                'question_id' => new Constraints\NotNull(),
                'title' => array(
                    new Constraints\NotNull(),
                    new Constraints\MaxLength(array('limit' => 255))
                ),
                'body' => new Constraints\NotNull(),
            ),
            'allowExtraFields' => false,
        ));

        return array(
            'validation_constraint' => $collectionConstraint,
        );
    }

    public function getName()
    {
        return 'comment';
    }
}
