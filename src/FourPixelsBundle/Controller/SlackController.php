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
    /* @var $client \Guzzle\Http\Client */
    /* @var $requestForSlack \Guzzle\Http\Message\Request */
    $logger = $this->get('logger');
    if ($request->isMethod('GET')) {
      $logger->info("----------------------------------------------");
      $logger->info("----------PARAMETERS FROM SLACK GET-----------");
      $logger->info("----------------------------------------------");
      $slackCode = $request->get('code');
      $slackState = $request->get('state');
      $logger->info("CODE -> " . $slackCode);
      $logger->info("STATE -> " . $slackState);
    } else if ($request->isMethod('POST')) {
      
    }


    // Create a client and provide a base URL
    $client = new \Guzzle\Http\Client('https://slack.com');
    $client->setDefaultOption('query', [
        'client_id' => $this->getParameter('slack.client_id'),
        'client_secret' => $this->getParameter('slack.client_secret'),
        'code' => $slackCode,
    ]);
    $requestForSlack = $client->get('/api/oauth.access');
    $response = $requestForSlack->send();
    $b = $response->getBody();
    $logger->info($b);
    $l = $response->getHeader('Content-Length');
    $logger->info($l);
    $data = $response->json();
    $logger->info($data);


    $logger->info("----------------------------------------------");
    $logger->info($request);
    $logger->info("*************************************************");
    $logger->info("----------------------------------------------");
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
   * @Annotations\Post("/slack/teamtreehouse")
   * @Annotations\View()
   *
   * @param Request               $request      the request object
   * @param ParamFetcherInterface $paramFetcher param fetcher service
   *
   * @return array
   */
  public function postSlackTeamtreehouseAction(Request $request, ParamFetcherInterface $paramFetcher) {
    return [
        'username' => 'pixels bot',
        'text' => 'Let the Team Tree House tournament begin, may the force be with you. :panda_face:',
        "channel" => "#testing-api",
        "icon_url" => "https://slack.com/img/icons/app-57.png",
        "icon_emoji" => ":ghost:"
    ];
  }

}
