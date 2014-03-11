<?php

namespace Lexik\Bundle\TranslationBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class TranslationAdmin extends Admin {
  
  protected function configureRoutes(RouteCollection $collection)
  {
    $collection->clearExcept(array('list'));
  }

}