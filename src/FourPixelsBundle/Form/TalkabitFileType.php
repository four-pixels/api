<?php

namespace FourPixelsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TalkabitFileType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('path', 'file', array('required' => false, 'data_class' => null, 'mapped' => true));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'data_class' => 'FourPixelsBundle\Entity\TalkabitFile',
    ));
  }

  public function getName() {
    return 'talkabitfile';
  }

}
