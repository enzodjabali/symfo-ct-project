<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserType extends AbstractType
{
    private ContainerBagInterface $containerBagInterface;
    private TokenStorageInterface $tokenStorage;

    public function __construct(ContainerBagInterface $containerBagInterface, TokenStorageInterface $tokenStorage)
    {
        $this->containerBagInterface = $containerBagInterface;
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $hierarchy = $this->containerBagInterface->get('security.role_hierarchy.roles');
        assert(is_array($hierarchy));

        $roles = [];

        foreach ($hierarchy as $arrayRole)
        {
            assert(is_array($arrayRole));
            
            $mainRole = $arrayRole[0];
            assert(is_string($mainRole));
            
            $roles[$mainRole] = $mainRole;
        }

        $authUserRole = $this->tokenStorage->getToken()->getRoleNames()[0];

        $builder
            ->add('email')
            ->add('verified')
        ;

        if ($authUserRole == 'ROLE_SUPER_ADMIN') {
            $builder->add('roles', ChoiceType::class, [
                'choices' => $roles
            ]);

            // Data transformer
            $builder->get('roles')
                ->addModelTransformer(new CallbackTransformer(
                    function (array $rolesArray) {
                        // transform the array to a string
                        return count($rolesArray)? $rolesArray[0]: null;
                    },
                    function (string $rolesString) {
                        // transform the string back to an array
                        return [$rolesString];
                    }
                ));
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
        ]);
    }
}
