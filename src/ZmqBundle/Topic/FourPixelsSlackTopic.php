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
    $this->logger->info("onPush -> " . $topic->getId());
    /* @var $slack \FourPixelsBundle\Entity\Slack */
    /* @var $slackRequest \FourPixelsBundle\Entity\SlackRequest */
    /* @var $slackTeamTreeHouse \FourPixelsBundle\Entity\SlackTeamTreeHouse */
    $this->em->clear();
    $slackRequest = $this->em->getRepository('FourPixelsBundle:SlackRequest')->find($request->getAttributes()->get('slackRequest'));
    $slack = $this->em->getRepository('FourPixelsBundle:Slack')->find($request->getAttributes()->get('slack'));
    $scoreTable = [];
    if ($slack->getId() === $slackRequest->getSlack()->getId()) {
      $client = new \Guzzle\Http\Client();
      $explode = explode(' ', $slackRequest->getText());
      $globalShowMode = 'in_channel';  // ephemeral OR in_channel
      switch ($explode[0]) {
        case 'help':
          $myArray = [
              'username' => '4pixels',
              "icon_url" => "https://slack.com/img/icons/app-57.png",
              "icon_emoji" => ":ghost:",
              "response_type" => $globalShowMode, // OR in_channel
              "attachments" => [
                  [
                      "fallback" => "please visit https://4pixels.co/api-help/list",
                      "title" => "LIST",
                      "text" => "/teamtreehouse list \n Displays a list of all the Team Tree House usernames participaiting in the tournament. \n *Example:* _/teamtreehouse list_",
                      "mrkdwn_in" => ['text'],
                      "color" => "#3F2860",
                  ],
                  [
                      "fallback" => "please visit https://4pixels.co/api-help/add",
                      "title" => "ADD",
                      "text" => "/teamtreehouse add `TeamTreeHouse username` \n adds a Team Tree House username to the tournament. \n *Example:* _/teamtreehouse add jasoncameron_",
                      "mrkdwn_in" => ['text'],
                      "color" => "#F35A00",
                  ],
                  [
                      "fallback" => "please visit https://4pixels.co/api-help/remove",
                      "title" => "REMOVE",
                      "text" => "/teamtreehouse remove `TeamTreeHouse username` \n Delete a Team Tree House username from the tournament. \n *Example:* _/teamtreehouse remove jasoncameron_",
                      "mrkdwn_in" => ['text'],
                      "color" => "#B81D18",
                  ],
                  [
                      "fallback" => "please visit https://4pixels.co/api-help/remove",
                      "title" => "SHOW",
                      "text" => "/teamtreehouse show `TeamTreeHouse username` \n Show a single Team Tree House username score. \n *Example:* _/teamtreehouse show jasoncameron_",
                      "mrkdwn_in" => ['text'],
                      "color" => "#1253A4",
                  ],
                  [
                      "fallback" => "please visit https://4pixels.co/api-help/code",
                      "title" => "CODE",
                      "text" => ""
                      . "/teamtreehouse code \n Displays a ranking list of Team Tree House usernames tournament. \n *Example:* _/teamtreehouse code_ \n\n"
                      . "/teamtreehouse code `TeamTreeHouse language` \n Displays a ranking list of Team Tree House usernames tournament based on one lenguage. \n *Example:* _/teamtreehouse code javascript_  \n\n"
                      . "/teamtreehouse code `TeamTreeHouse languages` \n Displays a ranking list of Team Tree House usernames tournament based on many lenguage. \n *Example:* _/teamtreehouse code javascript, php, html_"
                      ,
                      "mrkdwn_in" => ['text'],
                      "color" => "#75A3D1",
                  ],
              ]
          ];
          break;
        case 'show':
          //         /teamtreehouse show jasoncameron
          $username = $explode[1]; //MOST VALIDATE THERE ARE NO MORE PARAMETERS THAN 2
          try {
            $teamTreeHouseResponse = $client->get('https://teamtreehouse.com/' . $username . '.json')->send();
            $slackTeamTreeHouse = new \FourPixelsBundle\Entity\SlackTeamTreeHouse();
            $slackTeamTreeHouse->setContent($teamTreeHouseResponse->json());
            $myArray = [
                "response_type" => $globalShowMode, // OR in_channel
                "attachments" => [
                    [
                        "fallback" => "please visit https://4pixels.co/api-help/show",
                        "title" => "SHOW " . $slackTeamTreeHouse->getName() . " (" . $slackTeamTreeHouse->getProfileName() . ")",
                        "color" => "#75A3D1",
                        "thumb_url" => $slackTeamTreeHouse->getGravatarUrl(),
                        "fields" => $slackTeamTreeHouse->getPoints(true)
                    ],
                ]
            ];
          } catch (ClientErrorResponseException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            $myArray = [
                "response_type" => $globalShowMode, // OR in_channel
                "attachments" => [
                    [
                        "fallback" => "please visit https://4pixels.co/api-help/remove",
                        "title" => "SHOW " . $username . " - Ups !!! :panda_face: Panda Trouble",
                        "text" => "Username " . $responseBody . " on Team Tree House",
                        "mrkdwn_in" => ['text'],
                        "color" => "#D40E52",
                    ],
                ]
            ];
          }
          break;
        case 'code':
          $myArray = [
              "response_type" => $globalShowMode, // OR in_channel
              "attachments" => [
                  [
                      "fallback" => "please visit https://4pixels.co/api-help/code",
                      "title" => "Feature CODE",
                      "text" => "The panda is busy right know thinking in other stuff. He will develop this feature soon.",
                      "mrkdwn_in" => ['text'],
                      "color" => "#D40E52",
                  ],
              ]
          ];
          break;
        case 'list':
          $slackTeamTreeHouseList = $slack->getSlackTeamTreeHouseList();
          $text = "";
          foreach ($slackTeamTreeHouseList as $slackTeamTreeHouse) {
            $text .= $slackTeamTreeHouse->getName() . ' (' . $slackTeamTreeHouse->getProfileName() . ")\n";
          }
          $myArray = [
              "response_type" => $globalShowMode, // OR in_channel
              "attachments" => [
                  [
                      "fallback" => "please visit https://4pixels.co/api-help/list",
                      "title" => "LIST - List size: " . count($slackTeamTreeHouseList),
                      "text" => $text,
                      "color" => "#75A3D1",
                  ],
              ]
          ];
          break;
        case 'add':
          $username = $explode[1]; //MOST VALIDATE THERE ARE NO MORE PARAMETERS THAN 2
          try {
            $teamTreeHouseResponse = $client->get('https://teamtreehouse.com/' . $username . '.json')->send();
            $slackTeamTreeHouse = new \FourPixelsBundle\Entity\SlackTeamTreeHouse();
            $slackTeamTreeHouse->setContent($teamTreeHouseResponse->json());
            $slackTeamTreeHouse->setSlack($slack);
            $this->em->persist($slackTeamTreeHouse);
            $this->em->flush();
            $myArray = [
                "response_type" => $globalShowMode, // OR in_channel
                "attachments" => [
                    [
                        "fallback" => "please visit https://4pixels.co/api-help/add",
                        "title" => "ADD " . $slackTeamTreeHouse->getName() . " (" . $slackTeamTreeHouse->getProfileName() . ")",
                        "text" => "User has been added successfuly",
                        "color" => "#75A3D1",
                        "thumb_url" => $slackTeamTreeHouse->getGravatarUrl(),
                    ],
                ]
            ];
          } catch (ClientErrorResponseException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            $myArray = [
                "response_type" => $globalShowMode, // OR in_channel
                "attachments" => [
                    [
                        "fallback" => "please visit https://4pixels.co/api-help/add",
                        "title" => "ADD " . $username . " - Ups !!! :panda_face: Panda Trouble ",
                        "text" => "Username " . $responseBody . " on Team Tree House",
                        "color" => "#D40E52",
                    ],
                ]
            ];
          } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
            $this->em->clear();
            $myArray = [
                "response_type" => $globalShowMode, // OR in_channel
                "attachments" => [
                    [
                        "fallback" => "please visit https://4pixels.co/api-help/add",
                        "title" => "ADD " . $username . " - Ups !!! :panda_face: Panda Warning ",
                        "text" => "Username " . $username . " is already added",
                        "color" => "#FF9900",
                    ],
                ]
            ];
          }

          break;
        case 'remove':
          $username = $explode[1];
          $slackTeamTreeHouse = $this->em->getRepository('FourPixelsBundle:SlackTeamTreeHouse')->findOneBy(['slack' => $slack->getId(), 'profile_name' => $username]);
          if (!is_null($slackTeamTreeHouse)) {
            try {
              $name = $slackTeamTreeHouse->getName();
              $gravatarUrl = $slackTeamTreeHouse->getGravatarUrl();
              $this->em->remove($slackTeamTreeHouse);
              $this->em->flush();
              $myArray = [
                  "response_type" => $globalShowMode, // OR in_channel
                  "attachments" => [
                      [
                          "fallback" => "please visit https://4pixels.co/api-help/remove",
                          "title" => "REMOVE " . $name . " (" . $username . ")",
                          "text" => "User has been removed from the list successfuly",
                          "color" => "#75A3D1",
                          "thumb_url" => $gravatarUrl,
                      ],
                  ]
              ];
            } catch (\Exception $e) {
              $myArray = [
                  "response_type" => $globalShowMode, // OR in_channel
                  "attachments" => [
                      [
                          "fallback" => "please visit https://4pixels.co/api-help/remove",
                          "title" => "REMOVE " . $username . " - Ups !!! :panda_face: Panda Warning ",
                          "text" => "The was a problem removing the user from the list. ",
                          "color" => "#FF9900",
                      ],
                  ]
              ];
            }
          } else {
            $myArray = [
                "response_type" => $globalShowMode, // OR in_channel
                "attachments" => [
                    [
                        "fallback" => "please visit https://4pixels.co/api-help/remove",
                        "title" => "REMOVE " . $username . " - Ups !!! :panda_face: Panda Trouble ",
                        "text" => "Username was not found on the list. \n You can view the list with: /teamtreehouse list",
                        "color" => "#D40E52",
                    ],
                ]
            ];
          }
          break;
        default :
          $slackTeamTreeHouseList = $slackRequest->getSlack()->getSlackTeamTreeHouseList();

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
              "response_type" => $globalShowMode, // ephemeral OR in_channel
              "attachments" => [
                  [
                      "fallback" => "please visit https://4pixels.co/api-help",
                      "title" => "RANKING NEWS ",
                      "text" => $text,
                      "color" => "#75A3D1",
                  ],
              ],
          ];
          break;
      }















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
