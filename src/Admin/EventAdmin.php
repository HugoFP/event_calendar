<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
		    ->add('name', TextType::class)
			->add('date_from', DateType::class, array(
			    'widget' => 'single_text',
			    'html5' => false,
			    'attr' => ['class' => 'js-datepicker'],
			))

		    ->add('date_from', null,
                array(
                    'format' =>  'dd MMM yyyy',
                    'widget' => 'choice'
                )
            )

		    ->add('date_to', null,
                array(
                    'format' =>  'dd MMM yyyy',
                    'widget' => 'choice'
                )
            )

            ->add('capacity', TextType::class)

            ->add('is_active', null,
            	array(
	            	'required' => true,
	            )
            )

            ->add('notes', TextType::class)
		;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
    	$listMapper
            ->addIdentifier('name')
            ->add('date_from')
            ->add('date_to')
            ->add('is_active')
        ;
    }
}