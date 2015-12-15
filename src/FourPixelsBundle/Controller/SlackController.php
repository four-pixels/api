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

class SlackController extends FOSRestController {

  /**
   * Do something.
   *
   * @ApiDoc(
   *   resource = true,
   *   statusCodes = {
   *     200 = "Returned when successful"
   *   }
   * )
   *
   * @Annotations\View()
   *
   * @param Request               $request      the request object
   * @param ParamFetcherInterface $paramFetcher param fetcher service
   *
   * @return array
   */
  public function getSlackAction(Request $request, ParamFetcherInterface $paramFetcher) {
    return ['message' => 'hello'];
  }

  /**
   * Do something.
   *
   * @ApiDoc(
   *   statusCodes = {
   *     200 = "Returned when successful"
   *   }
   * )
   *
   * @Annotations\View()
   *
   * @param Request               $request      the request object
   * @param ParamFetcherInterface $paramFetcher param fetcher service
   *
   * @return array
   */
  public function getSlackInstructionsAction(Request $request, ParamFetcherInterface $paramFetcher) {
    return ['message' => 'testing the api - not much yet, may the force be with you.'];
  }

  /**
   * Do something.
   *
   * @ApiDoc(
   *   statusCodes = {
   *     200 = "Returned when successful"
   *   }
   * )
   *
   * @Annotations\View()
   *
   * @param Request               $request      the request object
   * @param ParamFetcherInterface $paramFetcher param fetcher service
   *
   * @return array
   */
  public function getSlackSupportAction(Request $request, ParamFetcherInterface $paramFetcher) {
    return ['message' => 'some support stuff required, may the force be with you.'];
  }

  /**
   * Do something.
   *
   * @ApiDoc(
   *   statusCodes = {
   *     200 = "Returned when successful"
   *   }
   * )
   *
   * @Annotations\View()
   *
   * @param Request               $request      the request object
   * @param ParamFetcherInterface $paramFetcher param fetcher service
   *
   * @return array
   */
  public function getSlackCallbackAction(Request $request, ParamFetcherInterface $paramFetcher) {
    return ['message' => 'some callback function here, may the force be with you.'];
  }

  /* --- TREE HOUSE STUFF --------------------------------------------------- */

  /**
   * Do something.
   *
   * @ApiDoc(
   *   statusCodes = {
   *     200 = "Returned when successful"
   *   }
   * )
   *
   * @Annotations\View()
   *
   * @param Request               $request      the request object
   * @param ParamFetcherInterface $paramFetcher param fetcher service
   *
   * @return array
   */
  public function getSlackTeamtreehouseAction(Request $request, ParamFetcherInterface $paramFetcher) {
    return ['text' => 'Let the Team Tree House tournament begin, may the force be with you.'];
  }

}
