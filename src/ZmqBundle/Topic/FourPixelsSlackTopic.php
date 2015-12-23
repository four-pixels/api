<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ZmqBundle\Topic;

use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;
use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\Topic\PushableTopicInterface;
use Symfony\Component\HttpKernel\Log\NullLogger;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;

class FourPixelsSlackTopic implements TopicInterface, PushableTopicInterface {

  /**
   * @var LoggerInterface 
   */
  private $logger;

  /**
   * @var EntityManager 
   */
  protected $em;

  public function __construct(LoggerInterface $logger, EntityManager $entityManager) {
    $this->logger = $logger === null ? new NullLogger() : $logger;
    $this->em = $entityManager;
    $this->logger->info("FourPixelsSlackTopic");
    $this->logger->info("__construct");
  }

  /**
   * This will receive any Subscription requests for this topic.
   *
   * @param ConnectionInterface $connection
   * @param Topic $topic
   * @param WampRequest $request
   * @return void
   */
  public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request) {
    //this will broadcast the message to ALL subscribers of this topic.
    $topic->broadcast(['msg' => $connection->resourceId . " has joined " . $topic->getId()]);
  }

  /**
   * This will receive any UnSubscription requests for this topic.
   *
   * @param ConnectionInterface $connection
   * @param Topic $topic
   * @param WampRequest $request
   * @return void
   */
  public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request) {
    //this will broadcast the message to ALL subscribers of this topic.
    $topic->broadcast(['msg' => $connection->resourceId . " has left " . $topic->getId()]);
  }

  /**
   * This will receive any Publish requests for this topic.
   *
   * @param ConnectionInterface $connection
   * @param Topic $topic
   * @param WampRequest $request
   * @param $event
   * @param array $exclude
   * @param array $eligible
   * @return mixed|void
   */
  public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible) {
    /*
      $topic->getId() will contain the FULL requested uri, so you can proceed based on that

      if ($topic->getId() === 'acme/channel/shout')
      //shout something to all subs.
     */

    $topic->broadcast([
        'msg' => $event,
    ]);
  }

  /**
   * @param Topic        $topic
   * @param WampRequest  $request
   * @param array|string $data
   * @param string       $provider The name of pusher who push the data
   */
  public function onPush(Topic $topic, WampRequest $request, $data, $provider) {
    $this->logger->info("onPush");
    /* @var $slack \FourPixelsBundle\Entity\Slack */
    /* @var $slackRequest \FourPixelsBundle\Entity\SlackRequest */
    /* @var $slackTeamTreeHouse \FourPixelsBundle\Entity\SlackTeamTreeHouse */
    $this->em->clear();
    $slackRequest = $this->em->getRepository('FourPixelsBundle:SlackRequest')->find($request->getAttributes()->get('slackRequest'));
    $slack = $this->em->getRepository('FourPixelsBundle:Slack')->find($request->getAttributes()->get('slack'));
    $scoreTable = [];
    if ($slack->getId() === $slackRequest->getSlack()->getId()) {
      $slackTeamTreeHouseList = $slackRequest->getSlack()->getSlackTeamTreeHouseList();
      $client = new \Guzzle\Http\Client();
      foreach ($slackTeamTreeHouseList as $slackTeamTreeHouse) {
        $teamTreeHouseResponse = $client->get('https://teamtreehouse.com/' . $slackTeamTreeHouse->getProfileName() . '.json')->send();
        $slackTeamTreeHouse->setContent($teamTreeHouseResponse->json());
        $this->em->persist($slackTeamTreeHouse);
        $scoreTable[$slackTeamTreeHouse->getName() . ' (' . $slackTeamTreeHouse->getProfileName() . ')'] = $slackTeamTreeHouse->getTotal();
      }
      $this->em->flush();
      $resultBool = arsort($scoreTable);
      $text = "";
      foreach ($scoreTable as $key => $value) {
        $text.= $value . " \t \t " . $key . " \n ";
      }
      $myArray = [
          "response_type" => "ephemeral", // ephemeral OR in_channel
          "attachments" => [
              [
                  "fallback" => "please visit https://4pixels.co/api-help",
                  "title" => "RANKING NEWS ",
                  "text" => $text,
                  "color" => "#75A3D1",
              ],
          ],
      ];
      $requestForSlack = $client->post($slackRequest->getResponseUrl(), [], ['payload' => json_encode($myArray)]);
      $response = $requestForSlack->send();
    }
    $topic->broadcast([
        'msg' => 'DONE',
    ]);
  }

  /**
   * Like RPC is will use to prefix the channel
   * @return string
   */
  public function getName() {
    return 'fourpixels.slack';
  }

}
