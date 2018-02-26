<?php
/**
 * Created by PhpStorm.
 * User: bgarnier
 * Date: 14/02/2018
 * Time: 15:23
 */
namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdvertEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('date');
    }

    public function getParent()
    {
        return AdvertType::class;
    }
}
