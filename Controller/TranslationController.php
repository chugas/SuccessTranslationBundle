<?php

namespace Lexik\Bundle\TranslationBundle\Controller;

use Lexik\Bundle\TranslationBundle\Form\TransUnitType;
use Sonata\AdminBundle\Controller\CRUDController as Controller;

class TranslationController extends Controller {

  public function listAction() {
    if (false === $this->admin->isGranted('LIST')) {
      throw new AccessDeniedException();
    }
    
    $storage = $this->get('lexik_translation.translation_storage');
    $transUnit = $this->get('lexik_translation.trans_unit.manager')->newInstance($this->getManagedLocales());

    $options = array(
        'domains'           => $storage->getTransUnitDomains(),
        'data_class'        => $storage->getModelClass('trans_unit'),
        'translation_class' => $storage->getModelClass('translation'),
    );

    $form = $this->createForm(new TransUnitType(), $transUnit, $options);    
    
    return $this->render('LexikTranslationBundle:Edition:grid.html.twig', array(
        'action'    => 'list',
        'layout'    => $this->container->getParameter('lexik_translation.base_layout'),
        'inputType' => $this->container->getParameter('lexik_translation.grid_input_type'),
        'locales'   => $this->getManagedLocales(),
        'form'      => $form->createView()
    ));    
  }

  protected function getManagedLocales() {
    return $this->container->getParameter('lexik_translation.managed_locales');
  }

}