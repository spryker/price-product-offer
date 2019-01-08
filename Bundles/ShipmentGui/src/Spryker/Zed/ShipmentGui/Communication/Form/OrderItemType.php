<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShipmentGui\Communication\Form;

use Generated\Shared\Transfer\ItemTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \Spryker\Zed\ShipmentGui\Business\SalesFacadeInterface getFacade()
 * @method \Spryker\Zed\ShipmentGui\Communication\SalesCommunicationFactory getFactory()
 * @method \Spryker\Zed\ShipmentGui\Persistence\SalesQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\ShipmentGui\SalesConfig getConfig()
 * @method \Spryker\Zed\ShipmentGui\Persistence\SalesRepositoryInterface getRepository()
 */
class OrderItemType extends AbstractType
{
    public const FIELD_ASSIGNED = 'assigned';

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'orderItem';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ItemTransfer::class,
        ));
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            static::FIELD_ASSIGNED,
            CheckboxType::class,
            [
                'mapped' => false,
                'label' => false,
                'required' => false,
            ]
        );
    }
}
