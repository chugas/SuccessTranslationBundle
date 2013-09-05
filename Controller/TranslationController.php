<?php

namespace Lexik\Bundle\TranslationBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class TranslationController extends Controller {

  public function listAction() {
    if (false === $this->admin->isGranted('LIST')) {
      throw new AccessDeniedException();
    }

    return $this->render($this->admin->getTemplate('list'), array(
                'action' => 'list',
                'layout' => $this->container->getParameter('lexik_translation.base_layout'),
                'inputType' => $this->container->getParameter('lexik_translation.grid_input_type'),
                'locales' => $this->getManagedLocales(),
            ));
  }

  protected function getManagedLocales() {
    return $this->container->getParameter('lexik_translation.managed_locales');
  }

}