<?php

namespace FourPixelsBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use JMS\Serializer\SerializerBuilder;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

class DefaultController extends FOSRestController {

  /**
   * Presents the form to use to create a new note.
   *
   * @ApiDoc(
   *   resource = true,
   *   statusCodes = {
   *     200 = "Returned when successful"
   *   }
   * )
   *
   * @Annotations\Get("/", name="api_home", options={ "method_prefix" = false })
   * @Annotations\View(template="FourPixelsBundle:Default:getDefault.html.twig")
   *
   * @return View
   */
  public function getDefaultAction() {
    return $this->view();
  }

}
