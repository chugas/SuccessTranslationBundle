<?php

namespace Lexik\Bundle\TranslationBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class TranslationAdmin extends Admin {
  
  public function getTemplate($name) {

    switch ($name) {
      case 'list':
        return 'SuccessAdminBundle:Translation:Edition/grid.html.twig';
        break;
      default:
        return parent::getTemplate($name);
        break;
    }
  }
  
  /**
   * Create and Edit
   * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
   *
   * @return void
   */
  /*protected function configureFormFields(FormMapper $formMapper) {
    $formMapper
              ->add('title')
              ->add('abstract', 'textarea')
            ;
  }*/

  /**
   * List
   * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
   *
   * @return void
   */
  /*protected function configureListFields(ListMapper $listMapper) {
    $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('abstract')
    ;
  }*/
  
  protected function configureRoutes(RouteCollection $collection)
  {
    $collection->clearExcept(array('list'));
  }

}