<?php

namespace FourPixelsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TalkabitFileMergeType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
            ->add('video', new TalkabitFileType())
            ->add('audio', new TalkabitFileType())
    ;
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'data_class' => 'FourPixelsBundle\Utils\TalkabitFileMerge',
    ));
  }

  public function getName() {
    return 'MergeFile';
  }

}
