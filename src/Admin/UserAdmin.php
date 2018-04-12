<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
		    ->add('username', TextType::class)
		    ->add('lastname', TextType::class)
		    ->add('email', TextType::class)
		    ->add('dni', TextType::class)
		    ->add('phone', TextType::class)
            ->add('is_active', null,
            	array(
	            	'required' => true,
	            )
            )
		;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('username');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
    		->addIdentifier('username')
		    //->add('username')
		    ->add('lastname')
		    ->add('email')
		    ->add('dni')
		    ->add('phone')
            ->add('is_active')
		;
    }
}