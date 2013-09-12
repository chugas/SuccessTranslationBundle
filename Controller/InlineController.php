<?php

namespace Lexik\Bundle\TranslationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Lexik\Bundle\TranslationBundle\Document\TransUnit as TransUnitDocument;
use Lexik\Bundle\TranslationBundle\Model\TransUnit;


/**
 * Translations edition controlller.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class InlineController extends Controller {

  public function includeAction() {
    $response = $this->render('LexikTranslationBundle:Inline:inline_js.html.twig');
    $response->setPrivate();
    return $response;
  }
  
  public function editableAction() {
    $response = $this->render('LexikTranslationBundle:Inline:editable.html.twig');
    $response->setPrivate();
    return $response;
  }  

  /**
   * Update a trans unit element from the javascript grid.
   *
   * @return \Symfony$view\Component\HttpFoundation\Response
   */
  public function updateAction() {
    $request = $this->get('request');

    if (!$request->isXmlHttpRequest()) {
      throw new NotFoundHttpException();
    }

    $response = new Response('', 200, array('Content-type' => 'application/json'));

    $storage = $this->get('lexik_translation.translation_storage');
    $transUnit = $storage->getTransUnitByKeyAndDomain($request->request->get('key'), $request->request->get('domain'));

    if (!($transUnit instanceof TransUnit)) {
      throw new NotFoundHttpException();
    }

    $translationsContent = array();
    foreach ($this->getManagedLocales() as $locale) {
      $translationsContent[$locale] = $request->request->get($locale);
    }

    $this->get('lexik_translation.trans_unit.manager')->updateTranslationsContent($transUnit, $translationsContent);

    if ($transUnit instanceof TransUnitDocument) {
      $transUnit->convertMongoTimestamp();
    }

    $storage->flush();

    $this->invalidateCache();

    $response->setContent(json_encode(array('message' => sprintf('TransUnit #%d updated.', $transUnit->getId()))));

    return $response;
  }

  /**
   * Remove cache files for managed locales.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   */
  protected function invalidateCache() {
    $this->get('translator')->removeLocalesCacheFiles($this->getManagedLocales());
  }

  /**
   * Returns managed locales.
   *
   * @return array
   */
  protected function getManagedLocales() {
    return $this->container->getParameter('lexik_translation.managed_locales');
  }

}
