<?php

namespace FourPixelsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SlackTeamTreeHouse
 *
 * @ORM\Table(name="slack_team_tree_house", uniqueConstraints={@ORM\UniqueConstraint(name="user_slack_unique", columns={"slack_id", "profile_name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class SlackTeamTreeHouse {

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id()
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="total" , type="integer", nullable=false)
   */
  protected $total;

  /**
   * @ORM\Column(name="name" , type="string", length=64 , nullable=false)
   */
  protected $name;

  /**
   * @ORM\Column(name="profile_name" , type="string", length=64 , nullable=false)
   */
  protected $profile_name;

  /**
   * @ORM\Column(name="profile_url" , type="text" , nullable=false)
   */
  protected $profile_url;

  /**
   * @ORM\Column(name="gravatar_url" , type="text" , nullable=false)
   */
  protected $gravatar_url;

  /**
   * @ORM\Column(name="gravatar_hash" , type="string", length=64 , nullable=false)
   */
  protected $gravatar_hash;

  /**
   * @ORM\Column(name="badges", type="text", nullable=false)
   */
  protected $badges;

  /**
   * @ORM\Column(name="points", type="text", nullable=false)
   */
  protected $points;

  /**
   * @ORM\Column(name="content", type="text", nullable=false)
   */
  protected $content;

  /**
   * @ORM\ManyToOne(targetEntity="Slack", inversedBy="slack_team_tree_house_list")
   * @ORM\JoinColumn(name="slack_id", referencedColumnName="id" , nullable=false)
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
    $this->total = 0;
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
   * Set name
   *
   * @param string $name
   *
   * @return SlackTeamTreeHouse
   */
  public function setName($name) {
    $this->name = $name;

    return $this;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set profileName
   *
   * @param string $profileName
   *
   * @return SlackTeamTreeHouse
   */
  public function setProfileName($profileName) {
    $this->profile_name = $profileName;

    return $this;
  }

  /**
   * Get profileName
   *
   * @return string
   */
  public function getProfileName() {
    return $this->profile_name;
  }

  /**
   * Set profileUrl
   *
   * @param string $profileUrl
   *
   * @return SlackTeamTreeHouse
   */
  public function setProfileUrl($profileUrl) {
    $this->profile_url = $profileUrl;

    return $this;
  }

  /**
   * Get profileUrl
   *
   * @return string
   */
  public function getProfileUrl() {
    return $this->profile_url;
  }

  /**
   * Set gravatarUrl
   *
   * @param string $gravatarUrl
   *
   * @return SlackTeamTreeHouse
   */
  public function setGravatarUrl($gravatarUrl) {
    $this->gravatar_url = $gravatarUrl;

    return $this;
  }

  /**
   * Get gravatarUrl
   *
   * @return string
   */
  public function getGravatarUrl() {
    return $this->gravatar_url;
  }

  /**
   * Set gravatarHash
   *
   * @param string $gravatarHash
   *
   * @return SlackTeamTreeHouse
   */
  public function setGravatarHash($gravatarHash) {
    $this->gravatar_hash = $gravatarHash;

    return $this;
  }

  /**
   * Get gravatarHash
   *
   * @return string
   */
  public function getGravatarHash() {
    return $this->gravatar_hash;
  }

  /**
   * Set badges
   *
   * @param string $badges
   *
   * @return SlackTeamTreeHouse
   */
  public function setBadges($badges) {
    $eval = $badges;
    if (is_array($eval)) {
      $badges = json_encode($eval);
    } else {
      $eval = json_decode($badges, true);
    }

    $this->badges = $badges;

    return $this;
  }

  /**
   * Get badges
   *
   * @return string
   */
  public function getBadges() {
    return $this->badges;
  }

  /**
   * Set points
   *
   * @param string $points
   *
   * @return SlackTeamTreeHouse
   */
  public function setPoints($points) {
    $eval = $points;
    if (is_array($eval)) {
      $points = json_encode($eval);
    } else {
      $eval = json_decode($points, true);
    }

    $this->points = $points;
    if (is_array($eval)) {
      $this->total = $eval['total'];
    }

    return $this;
  }

  /**
   * Get points
   *
   * @return string
   */
  public function getPoints($renderForSlack = false) {
    if ($renderForSlack) {
      $points = [];
      $total = null;
      foreach (json_decode($this->points) as $key => $value) {
        if ($key != "total") {
          $points[] = [
              "title" => $key,
              "value" => $value,
              "short" => true,
          ];
        } else {
          $total = [
              "title" => $key,
              "value" => $value,
              "short" => false,
          ];
        }
      }
      $points[] = $total;
      return $points;
    }

    return $this->points;
  }

  /**
   * Set createdAt
   *
   * @param \DateTime $createdAt
   *
   * @return SlackTeamTreeHouse
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
   * @return SlackTeamTreeHouse
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
   * @return SlackTeamTreeHouse
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

  /**
   * Set total
   *
   * @param integer $total
   *
   * @return SlackTeamTreeHouse
   */
  public function setTotal($total) {
    $this->total = $total;

    return $this;
  }

  /**
   * Get total
   *
   * @return integer
   */
  public function getTotal() {
    return $this->total;
  }

  /**
   * Set content
   *
   * @param string $content
   *
   * @return SlackTeamTreeHouse
   */
  public function setContent($content) {
    $eval = $content;
    if (is_array($eval)) {
      $content = json_encode($content);
    } else {
      $eval = json_decode($content);
    }
    $this->content = $content;
    if (is_array($eval)) {
      $this->setName($eval["name"]);
      $this->setProfileName($eval["profile_name"]);
      $this->setProfileUrl($eval["profile_url"]);
      $this->setGravatarUrl($eval["gravatar_url"]);
      $this->setGravatarHash($eval["gravatar_hash"]);
      $this->setBadges($eval['badges']);
      $this->setPoints($eval['points']);
    }
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

}
