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


//    {
//    "ok":true,
//    "access_token":"xoxp-10774936049-11047021873-16972576145-eef0101933",
//    "scope":"identify,incoming-webhook,commands,chat:write:user,bot",
//    "team_name":"4Pixels",
//    "team_id":"T0ANSTJ1F",
//    "incoming_webhook": {
//      "channel":"testing-api",
//      "configuration_url":"https:\/\/conexx-media.slack.com\/services\/B0GUM5QF8",
//      "url":"https:\/\/hooks.slack.com\/services\/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"
//
//      },
//      "bot": {
//        "bot_user_id":"U0GUGV4Q5",
//        "bot_access_token":"xoxb-16968990821-N1VT65cY5QyyNZt9szEjAPbk"
//      }
//    } 
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

    $request->
            /* @var $client \Guzzle\Http\Client */
            /* @var $requestForSlack \Guzzle\Http\Message\Request */
            $logger = $this->get('logger');

    $logger->info("----------------------------------------------");
    $logger->info("------------getSlackCallbackAction------------");
    $logger->info("----------------------------------------------");
    $slackCode = $request->get('code');
    $slackState = $request->get('state');
    $logger->info("CODE -> " . $slackCode);
    $logger->info("STATE -> " . $slackState);
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
    $logger->info("----------------------------------------------");
    $logger->info("*************************************************");
    $logger->info("----------------------------------------------");
    return ['text' => 'some callback function here, may the force be with you.'];
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
    $logger = $this->get('logger');
    $logger->info("----------------------------------------------");
    $logger->info("---------postSlackTeamtreehouseAction---------");
    $logger->info("----------------------------------------------");
    /*
     * token=UOvVZxIcQRhqYPfrNGv717HT
     * team_id=T0ANSTJ1F
     * team_domain=conexx-media
     * channel_id=G0GKWJM8T
     * channel_name=privategroup
     * user_id=U0B1D0MRP
     * user_name=rene.ramirez
     * command=/teamtreehouse
     * text= SOME TEXT
     * response_url=https%3A%2F%2Fhooks.slack.com%2Fcommands%2FT0ANSTJ1F%2F16834218929%2FB9gnYQ8c7zT6LcsftrL85iXo 
     */

    $token = $request->get('token');
    $team_id = $request->get('team_id');
    $team_domain = $request->get('team_domain');
    $channel_id = $request->get('channel_id');
    $channel_name = $request->get('channel_name');
    $user_id = $request->get('user_id');
    $user_name = $request->get('user_name');
    $command = $request->get('command');
    $text = $request->get('text');
    $response_url = $request->get('response_url');
    $client = new \Guzzle\Http\Client();
    $randomWord = $client->get('http://randomword.setgetgo.com/get.php')->send();

    $myArray = [
        'username' => '4pixels',
        "icon_url" => "https://slack.com/img/icons/app-57.png",
        "icon_emoji" => ":ghost:",
        "text" => "<https://alert-system.com/alerts/1234|Click here> for details!",
        "response_type" => "ephemeral", // OR in_channel OR ephemeral
        "attachments" => [
            [
                "fallback" => "fallback stuff: https://honeybadger.io/path/to/event/",
                "text" => "<http://bike.4pixels.co|THE LINK XD> - \n This is a text that has a link on the beggining \n Testing *right now!*",
                "author_name" => "Erick Hernandez - author_name",
                "author_link" => "http://flickr.com/bobby/",
                "author_icon" => "http://flickr.com/icons/bobby.jpg",
                "title" => "THE TITLE, its a link and i think its because we set title_link",
                "title_link" => "https://api.slack.com/",
                "pretext" => "Pretext _supports_ mrkdwn",
                "mrkdwn_in" => ["text", "pretext"],
                "fields" => [
                    [
                        "title" => "SMALL BOX 1",
                        "value" => "This is othe small box over here, yeah, that happend.",
                        "short" => true,
                    ],
                    [
                        "title" => "SMALL BOX 2",
                        "value" => "This is othe small box over here, yeah, that happend.",
                        "short" => true
                    ],
                    [
                        "title" => "SMALL BOX 3",
                        "value" => "OK last small box, just saying. ",
                        "short" => true
                    ],
                    [
                        "title" => "BIG BOX 1",
                        "value" => "some big box that fill all the way, for some test this dudes are having.",
                        "short" => false
                    ],
                    [
                        "title" => "BIG BOX 2",
                        "value" => "The other big box, just to see what happends that it. no big deal.",
                        "short" => false
                    ],
                    [
                        "title" => "token",
                        "value" => $token,
                        "short" => true
                    ],
                    [
                        "title" => "team_id",
                        "value" => $team_id,
                        "short" => true
                    ],
                    [
                        "title" => "team_domain",
                        "value" => $team_domain,
                        "short" => true
                    ],
                    [
                        "title" => "channel_id",
                        "value" => $channel_id,
                        "short" => true
                    ],
                    [
                        "title" => "channel_name",
                        "value" => $channel_name,
                        "short" => true
                    ],
                    [
                        "title" => "user_id",
                        "value" => $user_id,
                        "short" => true
                    ],
                    [
                        "title" => "user_name",
                        "value" => $user_name,
                        "short" => true
                    ],
                    [
                        "title" => "command",
                        "value" => $command,
                        "short" => true
                    ],
                    [
                        "title" => "text",
                        "value" => $text,
                        "short" => true
                    ],
                    [
                        "title" => "response_url",
                        "value" => $response_url,
                        "short" => true
                    ],
                ],
                "color" => "#F35A00",
                "image_url" => "http://i2.cdn.turner.com/cnnnext/dam/assets/111017060721-giant-panda-bamboo-story-top.jpg",
                "thumb_url" => "https://www.inaturalist.org/assets/iconic_taxa/aves-75px-e9253c448d11ff2e49af2861d650b9bd.png"
            ]
        ]
    ];



    $explode = explode(' ', $text);
    $globalShowMode = 'ephemeral';  // ephemeral OR in_channel
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
          $teamTreeHouseJson = $teamTreeHouseResponse->json();
          $user = [];
          $points = [];
          foreach ($teamTreeHouseJson['points'] as $key => $value) {
            $logger->info("(((1))) " . $key . ' => ' . $value);
            $points[] = [
                "title" => $key,
                "value" => $value,
                "short" => true,
            ];
          }
          $myArray = [
              "response_type" => $globalShowMode, // OR in_channel
              "attachments" => [
                  [
                      "fallback" => "please visit https://4pixels.co/api-help/show",
                      "title" => "SHOW " . $teamTreeHouseJson['name'] . "(" . $username . ")",
                      "color" => "#75A3D1",
                      "thumb_url" => $teamTreeHouseJson['gravatar_url'],
                      "fields" => $points
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
            'text' => ":panda_face: Panda is thinking in " . $randomWord->getBody(),
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
        $myArray = [
            "response_type" => $globalShowMode, // OR in_channel
            'text' => ":panda_face: Panda is thinking in " . $randomWord->getBody(),
            "attachments" => [
                [
                    "fallback" => "please visit https://4pixels.co/api-help/list",
                    "title" => "Feature LIST",
                    "text" => "The panda is busy right know thinking in other stuff. He will develop this feature soon.",
                    "mrkdwn_in" => ['text'],
                    "color" => "#D40E52",
                ],
            ]
        ];
        break;
      case 'add':
        $myArray = [
            "response_type" => $globalShowMode, // OR in_channel
            'text' => ":panda_face: Panda is thinking in " . $randomWord->getBody(),
            "attachments" => [
                [
                    "fallback" => "please visit https://4pixels.co/api-help/add",
                    "title" => "Feature ADD",
                    "text" => "The panda is busy right know thinking in other stuff. He will develop this feature soon.",
                    "mrkdwn_in" => ['text'],
                    "color" => "#D40E52",
                ],
            ]
        ];
        break;
      case 'remove':
        $myArray = [
            "response_type" => $globalShowMode, // OR in_channel
            'text' => ":panda_face: Panda is thinking in " . $randomWord->getBody(),
            "attachments" => [
                [
                    "fallback" => "please visit https://4pixels.co/api-help/remove",
                    "title" => "Feature REMOVE",
                    "text" => "The panda is busy right know thinking in other stuff. He will develop this feature soon.",
                    "mrkdwn_in" => ['text'],
                    "color" => "#D40E52",
                ],
            ]
        ];
        break;
      default :
        $myArray = [
            "response_type" => $globalShowMode, // OR in_channel
            'text' => ":panda_face: Panda is thinking in " . $randomWord->getBody(),
            "attachments" => [
                [
                    "fallback" => "please visit https://4pixels.co/api-help",
                    "title" => "Feature GLOBAL RANKING",
                    "text" => "The panda is busy right know thinking in other stuff. He will develop this feature soon.",
                    "mrkdwn_in" => ['text'],
                    "color" => "#D40E52",
                ],
            ]
        ];
        break;
    }




//   THIS WORKS -> JUST FOR THE FUTURE USE
    $requestForSlack = $client->post($response_url, [], ['payload' => json_encode($myArray)]);
    $response = $requestForSlack->send();



    return $this->view(['text' => ":panda_face: Panda is thinking in " . $randomWord->getBody(), "response_type" => "ephemeral"], Response::HTTP_OK);
  }

}
