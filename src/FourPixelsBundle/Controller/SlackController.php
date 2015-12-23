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


//GET /api/slack/callback?code=10774936049.16968959669.95e76d0d0a&state=X+bEw HTTP/1.1 
//        Accept:                    text/html,application/xhtml+xml,application/xml; q=0.9,image/webp,*/*;q=0.8 
//Accept-Encoding:           gzip, deflate, sdch 
//Accept-Language:           en-US,en;q=0.8,es;q=0.6 
//Cache-Control:             max-age=0 
//Connection:                keep-alive 
//Cookie:                    wordpress_test_cookie=WP+Cookie+check 
//Host:                      4pixels.co 
//Upgrade-Insecure-Requests: 1 
//User-Agent:                Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36 X-Php-Ob-Level:  

    /* @var $client \Guzzle\Http\Client */
    /* @var $requestForSlack \Guzzle\Http\Message\Request */
    $em = $this->getDoctrine()->getManager();
    $logger = $this->get('logger');

    $logger->info("----------------------------------------------");
    $logger->info("------------getSlackCallbackAction------------");
    $logger->info("----------------------------------------------");
    $slackCode = $request->get('code');
    $slackState = $request->get('state');
    // Create a client and provide a base URL
    $client = new \Guzzle\Http\Client('https://slack.com');
    $client->setDefaultOption('query', [
        'client_id' => $this->getParameter('slack.client_id'),
        'client_secret' => $this->getParameter('slack.client_secret'),
        'code' => $slackCode,
    ]);
    $requestForSlack = $client->get('/api/oauth.access');
    $response = $requestForSlack->send();
    $slackJson = $response->getBody();
    $logger->info($slackJson);
    $serializer = $this->getSerializer();
    $slack = $serializer->deserialize($slackJson, 'FourPixelsBundle\Entity\Slack', 'json');
    $slack->setContent($slackJson);
    $em->persist($slack);
    $em->flush();
    return $this->redirect('https://4pixels.co', Response::HTTP_FOUND);
  }

  /* --- TREE HOUSE STUFF --------------------------------------------------- */




  /* $myArray = [
   *     'username' => '4pixels',
   *     "icon_url" => "https://slack.com/img/icons/app-57.png",
   *     "icon_emoji" => ":ghost:",
   *     "text" => "<https://alert-system.com/alerts/1234|Click here> for details!",
   *     "response_type" => "ephemeral", // OR in_channel OR ephemeral
   *     "attachments" => [
   *         [
   *             "fallback" => "fallback stuff: https://honeybadger.io/path/to/event/",
   *             "text" => "<http://bike.4pixels.co|THE LINK XD> - \n This is a text that has a link on the beggining \n Testing *right now!*",
   *             "author_name" => "Erick Hernandez - author_name",
   *             "author_link" => "http://flickr.com/bobby/",
   *            "author_icon" => "http://flickr.com/icons/bobby.jpg",
   *             "title" => "THE TITLE, its a link and i think its because we set title_link",
   *             "title_link" => "https://api.slack.com/",
   *             "pretext" => "Pretext _supports_ mrkdwn",
   *             "mrkdwn_in" => ["text", "pretext"],
   *             "fields" => [
   *                 [
   *                     "title" => "SMALL BOX 1",
   *                     "value" => "This is othe small box over here, yeah, that happend.",
   *                     "short" => true,
   *                 ],
   *             ],
   *             "color" => "#F35A00",
   *             "image_url" => "http://i2.cdn.turner.com/cnnnext/dam/assets/111017060721-giant-panda-bamboo-story-top.jpg",
   *             "thumb_url" => "https://www.inaturalist.org/assets/iconic_taxa/aves-75px-e9253c448d11ff2e49af2861d650b9bd.png"
   *         ]
   *     ]
   * ];
   */

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
    /* @var $slack \FourPixelsBundle\Entity\Slack */
    $logger = $this->get('logger');
    $logger->info("----------------------------------------------");
    $logger->info("---------postSlackTeamtreehouseAction---------");
    $logger->info("----------------------------------------------");
    $slack = $this->getDoctrine()->getRepository('FourPixelsBundle:Slack')->findOneBy(['team_id' => $request->get('team_id')]);
    if (!is_null($slack)) {
      $em = $this->getDoctrine()->getManager();
      $slackRequest = new \FourPixelsBundle\Entity\SlackRequest();
      $slackRequest->setToken($request->get('token'));
      $slackRequest->setTeamId($request->get('team_id'));
      $slackRequest->setTeamDomain($request->get('team_domain'));
      $slackRequest->setChannelId($request->get('channel_id'));
      $slackRequest->setChannelName($request->get('channel_name'));
      $slackRequest->setUserId($request->get('user_id'));
      $slackRequest->setUserName($request->get('user_name'));
      $slackRequest->setCommand($request->get('command'));
      $slackRequest->setText($request->get('text'));
      $slackRequest->setResponseUrl($request->get('response_url'));
      $slackRequest->setSlack($slack);
      $em->persist($slackRequest);
      $em->flush();
      /* CALL ZMQ to handle the workload overhead */
      $pusher = $this->get('gos_web_socket.zmq.pusher');
      $pusher->push([], 'fourpixels_slack', ['slack' => $slack->getId(), 'slackRequest' => $slackRequest->getId()]);
    }
    $client = new \Guzzle\Http\Client();
    $randomWord = $client->get('http://randomword.setgetgo.com/get.php')->send();
    return $this->view(['text' => ":panda_face: Panda is thinking in " . $randomWord->getBody(), "response_type" => "in_channel"], Response::HTTP_OK);
  }

  private function getSerializer() {
    $encoders = array(new \Symfony\Component\Serializer\Encoder\JsonEncoder());
    $normalizers = array(new \Symfony\Component\Serializer\Normalizer\ObjectNormalizer());
    $serializer = new \Symfony\Component\Serializer\Serializer($normalizers, $encoders);
    return $serializer;
  }

}
