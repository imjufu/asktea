<?php

namespace Asktea\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Symfony\Component\Validator\Constraints;


class SigninType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('login', 'text', array('label' => 'Identifiant'))
            ->add('password', 'password', array('label' => 'Mot de passe'));
    }

    public function getDefaultOptions(array $options)
    {
        // Collection Constraint
        $collectionConstraint = new Constraints\Collection(array(
            'fields' => array(
                'login' => new Constraints\NotNull(),
                'password' => new Constraints\NotNull(),
            ),
            'allowExtraFields' => false,
        ));

        return array(
            'validation_constraint' => $collectionConstraint,
        );
    }

    public function getName()
    {
        return 'signin';
    }
}
