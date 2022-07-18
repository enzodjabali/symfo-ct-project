<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class UserType extends AbstractType
{

    private RoleHierarchyInterface $roleHierarchyInterface;

    public function __construct(RoleHierarchyInterface $roleHierarchyInterface)
    {
        
        $this->roleHierarchyInterface = $roleHierarchyInterface;
        // dd($roleHierarchyInterface);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'ROLE_USER' => "ROLE_USER",
                    'ROLE_ADMIN' => "ROLE_ADMIN",
                    'ROLE_SUPER_ADMIN' => "ROLE_SUPER_ADMIN",
                ],
                
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
