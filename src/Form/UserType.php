<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{

    private ContainerBagInterface $containerBagInterface;

    public function __construct(ContainerBagInterface $containerBagInterface)
    {
        $this->containerBagInterface = $containerBagInterface;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $hierarchy = $this->containerBagInterface->get('security.role_hierarchy.roles');
        // dd(array_keys($hierarchy));
        $roles = [];

        foreach ($hierarchy as $arrayRole)
        {
     
            $roles[$arrayRole[0]] = $arrayRole[0];
        }
        // array_walk_recursive($hierarchy, function($role) use (&$roles)
        // {
        //     $roles[$role] = $role;
        // });

        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => $roles
            ])
        ;

        // Data transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                     // transform the array to a string
                     return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                     // transform the string back to an array
                     return [$rolesString];
                }
        ));
 
    }

    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
        ]);
    }
}
