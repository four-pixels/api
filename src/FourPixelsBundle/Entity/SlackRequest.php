<?php

namespace FourPixelsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SlackRequest
 *
 * @ORM\Table(name="slack_request")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class SlackRequest {

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id()
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="token" , type="string", length=32 , nullable=false)
   */
  protected $token;

  /**
   * @ORM\Column(name="team_id" , type="string", length=64 , nullable=false)
   */
  protected $team_id;

  /**
   * @ORM\Column(name="team_domain" , type="string", length=64 , nullable=false)
   */
  protected $team_domain;

  /**
   * @ORM\Column(name="channel_id" , type="string", length=64 , nullable=false)
   */
  protected $channel_id;

  /**
   * @ORM\Column(name="channel_name" , type="string", length=64 , nullable=false)
   */
  protected $channel_name;

  /**
   * @ORM\Column(name="user_id" , type="string", length=64 , nullable=false)
   */
  protected $user_id;

  /**
   * @ORM\Column(name="user_name" , type="string", length=64 , nullable=false)
   */
  protected $user_name;

  /**
   * @ORM\Column(name="command" , type="string", length=32 , nullable=false)
   */
  protected $command;

  /**
   * @ORM\Column(name="text" , type="string", length=32 , nullable=false)
   */
  protected $text;

  /**
   * @ORM\Column(name="response_url" , type="string", length=255 , nullable=false)
   */
  protected $response_url;
// ...
  /**
   * @ORM\ManyToOne(targetEntity="Slack", inversedBy="slack_requests")
   * @ORM\JoinColumn(name="slack_id", referencedColumnName="id", nullable=false)
   */
  private $slack;

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
   * Set token
   *
   * @param string $token
   *
   * @return SlackRequest
   */
  public function setToken($token) {
    $this->token = $token;

    return $this;
  }

  /**
   * Get token
   *
   * @return string
   */
  public function getToken() {
    return $this->token;
  }

  /**
   * Set teamId
   *
   * @param string $teamId
   *
   * @return SlackRequest
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
   * Set teamDomain
   *
   * @param string $teamDomain
   *
   * @return SlackRequest
   */
  public function setTeamDomain($teamDomain) {
    $this->team_domain = $teamDomain;

    return $this;
  }

  /**
   * Get teamDomain
   *
   * @return string
   */
  public function getTeamDomain() {
    return $this->team_domain;
  }

  /**
   * Set channelId
   *
   * @param string $channelId
   *
   * @return SlackRequest
   */
  public function setChannelId($channelId) {
    $this->channel_id = $channelId;

    return $this;
  }

  /**
   * Get channelId
   *
   * @return string
   */
  public function getChannelId() {
    return $this->channel_id;
  }

  /**
   * Set channelName
   *
   * @param string $channelName
   *
   * @return SlackRequest
   */
  public function setChannelName($channelName) {
    $this->channel_name = $channelName;

    return $this;
  }

  /**
   * Get channelName
   *
   * @return string
   */
  public function getChannelName() {
    return $this->channel_name;
  }

  /**
   * Set userId
   *
   * @param string $userId
   *
   * @return SlackRequest
   */
  public function setUserId($userId) {
    $this->user_id = $userId;

    return $this;
  }

  /**
   * Get userId
   *
   * @return string
   */
  public function getUserId() {
    return $this->user_id;
  }

  /**
   * Set userName
   *
   * @param string $userName
   *
   * @return SlackRequest
   */
  public function setUserName($userName) {
    $this->user_name = $userName;

    return $this;
  }

  /**
   * Get userName
   *
   * @return string
   */
  public function getUserName() {
    return $this->user_name;
  }

  /**
   * Set command
   *
   * @param string $command
   *
   * @return SlackRequest
   */
  public function setCommand($command) {
    $this->command = $command;

    return $this;
  }

  /**
   * Get command
   *
   * @return string
   */
  public function getCommand() {
    return $this->command;
  }

  /**
   * Set text
   *
   * @param string $text
   *
   * @return SlackRequest
   */
  public function setText($text) {
    $this->text = $text;

    return $this;
  }

  /**
   * Get text
   *
   * @return string
   */
  public function getText() {
    return $this->text;
  }

  /**
   * Set responseUrl
   *
   * @param string $responseUrl
   *
   * @return SlackRequest
   */
  public function setResponseUrl($responseUrl) {
    $this->response_url = $responseUrl;

    return $this;
  }

  /**
   * Get responseUrl
   *
   * @return string
   */
  public function getResponseUrl() {
    return $this->response_url;
  }

  /**
   * Set createdAt
   *
   * @param \DateTime $createdAt
   *
   * @return SlackRequest
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
   * @return SlackRequest
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
   * Set slack
   *
   * @param \FourPixelsBundle\Entity\Slack $slack
   *
   * @return SlackRequest
   */
  public function setSlack(\FourPixelsBundle\Entity\Slack $slack = null) {
    $this->slack = $slack;

    return $this;
  }

  /**
   * Get slack
   *
   * @return \FourPixelsBundle\Entity\Slack
   */
  public function getSlack() {
    return $this->slack;
  }

}
