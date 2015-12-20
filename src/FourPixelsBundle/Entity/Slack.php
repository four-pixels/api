<?php

namespace FourPixelsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Phone
 *
 * @ORM\Table(name="slack")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Slack {

//    {
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
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id()
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="ok", type="boolean", nullable=false)
   */
  protected $ok;

  /**
   * @ORM\Column(name="access_token" , type="string", length=64 , nullable=false)
   */
  protected $access_token;

  /**
   * @ORM\Column(name="team_name" , type="string", length=64 , nullable=false)
   */
  protected $team_name;

  /**
   * @ORM\Column(name="team_id" , type="string", length=64 , nullable=false)
   */
  protected $team_id;

  /**
   * @ORM\Column(name="incoming_webhook_channel" , type="string", length=64 , nullable=false)
   */
  protected $incoming_webhook_channel;

  /**
   * @ORM\Column(name="incoming_webhook_configuration_url" , type="string", length=255 , nullable=false)
   */
  protected $incoming_webhook_configuration_url;

  /**
   * @ORM\Column(name="incoming_webhook_url" , type="string", length=255 , nullable=false)
   */
  protected $incoming_webhook_url;

  /**
   * @ORM\Column(name="bot_user_id" , type="string", length=32 , nullable=true)
   */
  protected $bot_user_id;

  /**
   * @ORM\Column(name="bot_access_token" , type="string", length=64 , nullable=true)
   */
  protected $bot_access_token;

  /**
   * @ORM\Column(name="content", type="text", nullable=false)
   */
  protected $content;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="created_at", type="datetime", nullable=false)
   * @Gedmo\Timestampable(on="create")
   */
  protected $createdAt;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="updated_at", type="datetime", nullable=true)
   * @Gedmo\Timestampable(on="update")
   */
  protected $updatedAt;

  /**
   * Constructor
   */
  public function __construct() {
    
  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set ok
   *
   * @param boolean $ok
   *
   * @return Slack
   */
  public function setOk($ok) {
    $this->ok = $ok;

    return $this;
  }

  /**
   * Get ok
   *
   * @return boolean
   */
  public function getOk() {
    return $this->ok;
  }

  /**
   * Set accessToken
   *
   * @param string $accessToken
   *
   * @return Slack
   */
  public function setAccessToken($accessToken) {
    $this->access_token = $accessToken;

    return $this;
  }

  /**
   * Get accessToken
   *
   * @return string
   */
  public function getAccessToken() {
    return $this->access_token;
  }

  /**
   * Set teamName
   *
   * @param string $teamName
   *
   * @return Slack
   */
  public function setTeamName($teamName) {
    $this->team_name = $teamName;

    return $this;
  }

  /**
   * Get teamName
   *
   * @return string
   */
  public function getTeamName() {
    return $this->team_name;
  }

  /**
   * Set teamId
   *
   * @param string $teamId
   *
   * @return Slack
   */
  public function setTeamId($teamId) {
    $this->team_id = $teamId;

    return $this;
  }

  /**
   * Get teamId
   *
   * @return string
   */
  public function getTeamId() {
    return $this->team_id;
  }

  /**
   * Set content
   *
   * @param string $content
   *
   * @return Slack
   */
  public function setContent($content) {
    $this->content = $content;

    return $this;
  }

  /**
   * Get content
   *
   * @return string
   */
  public function getContent() {
    return $this->content;
  }

  /**
   * Set createdAt
   *
   * @param \DateTime $createdAt
   *
   * @return Slack
   */
  public function setCreatedAt($createdAt) {
    $this->createdAt = $createdAt;

    return $this;
  }

  /**
   * Get createdAt
   *
   * @return \DateTime
   */
  public function getCreatedAt() {
    return $this->createdAt;
  }

  /**
   * Set updatedAt
   *
   * @param \DateTime $updatedAt
   *
   * @return Slack
   */
  public function setUpdatedAt($updatedAt) {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  /**
   * Get updatedAt
   *
   * @return \DateTime
   */
  public function getUpdatedAt() {
    return $this->updatedAt;
  }

  /**
   * Set incomingWebhookChannel
   *
   * @param string $incomingWebhookChannel
   *
   * @return Slack
   */
  public function setIncomingWebhookChannel($incomingWebhookChannel) {
    $this->incoming_webhook_channel = $incomingWebhookChannel;

    return $this;
  }

  /**
   * Get incomingWebhookChannel
   *
   * @return string
   */
  public function getIncomingWebhookChannel() {
    return $this->incoming_webhook_channel;
  }

  /**
   * Set incomingWebhookConfigurationUrl
   *
   * @param string $incomingWebhookConfigurationUrl
   *
   * @return Slack
   */
  public function setIncomingWebhookConfigurationUrl($incomingWebhookConfigurationUrl) {
    $this->incoming_webhook_configuration_url = $incomingWebhookConfigurationUrl;

    return $this;
  }

  /**
   * Get incomingWebhookConfigurationUrl
   *
   * @return string
   */
  public function getIncomingWebhookConfigurationUrl() {
    return $this->incoming_webhook_configuration_url;
  }

  /**
   * Set incomingWebhookUrl
   *
   * @param string $incomingWebhookUrl
   *
   * @return Slack
   */
  public function setIncomingWebhookUrl($incomingWebhookUrl) {
    $this->incoming_webhook_url = $incomingWebhookUrl;

    return $this;
  }

  /**
   * Get incomingWebhookUrl
   *
   * @return string
   */
  public function getIncomingWebhookUrl() {
    return $this->incoming_webhook_url;
  }

  /**
   * Set botUserId
   *
   * @param string $botUserId
   *
   * @return Slack
   */
  public function setBotUserId($botUserId) {
    $this->bot_user_id = $botUserId;

    return $this;
  }

  /**
   * Get botUserId
   *
   * @return string
   */
  public function getBotUserId() {
    return $this->bot_user_id;
  }

  /**
   * Set botAccessToken
   *
   * @param string $botAccessToken
   *
   * @return Slack
   */
  public function setBotAccessToken($botAccessToken) {
    $this->bot_access_token = $botAccessToken;

    return $this;
  }

  /**
   * Get botAccessToken
   *
   * @return string
   */
  public function getBotAccessToken() {
    return $this->bot_access_token;
  }

  public function setIncomingWebhook($incomingWebhook) {
    $this->incoming_webhook_channel = $incomingWebhook["channel"];
    $this->incoming_webhook_configuration_url = $incomingWebhook["configuration_url"];
    $this->incoming_webhook_url = $incomingWebhook["url"];
    return $this;
  }

  public function setBot($bot) {
    $this->bot_access_token = $bot["bot_access_token"];
    $this->bot_user_id = $bot["bot_user_id"];
    return $this;
  }

}
