<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FourPixelsBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser {

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   * @ORM\Column(name="firstname", type="string", length=64, nullable=true)
   */
  protected $firstname;

  /**
   * @var string
   * @ORM\Column(name="lastname", type="string", length=64, nullable=true)
   */
  protected $lastname;

  /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
  protected $facebook_id;

  /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
  protected $facebook_access_token;

  /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
  protected $google_id;

  /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
  protected $google_access_token;

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

  public function __construct() {
    parent::__construct();
    // your own logic
  }

  /**
   * Set facebookId
   *
   * @param string $facebookId
   *
   * @return User
   */
  public function setFacebookId($facebookId) {
    $this->facebook_id = $facebookId;

    return $this;
  }

  /**
   * Get facebookId
   *
   * @return string
   */
  public function getFacebookId() {
    return $this->facebook_id;
  }

  /**
   * Set facebookAccessToken
   *
   * @param string $facebookAccessToken
   *
   * @return User
   */
  public function setFacebookAccessToken($facebookAccessToken) {
    $this->facebook_access_token = $facebookAccessToken;

    return $this;
  }

  /**
   * Get facebookAccessToken
   *
   * @return string
   */
  public function getFacebookAccessToken() {
    return $this->facebook_access_token;
  }

  /**
   * Set googleId
   *
   * @param string $googleId
   *
   * @return User
   */
  public function setGoogleId($googleId) {
    $this->google_id = $googleId;

    return $this;
  }

  /**
   * Get googleId
   *
   * @return string
   */
  public function getGoogleId() {
    return $this->google_id;
  }

  /**
   * Set googleAccessToken
   *
   * @param string $googleAccessToken
   *
   * @return User
   */
  public function setGoogleAccessToken($googleAccessToken) {
    $this->google_access_token = $googleAccessToken;

    return $this;
  }

  /**
   * Get googleAccessToken
   *
   * @return string
   */
  public function getGoogleAccessToken() {
    return $this->google_access_token;
  }

  /**
   * Set createdAt
   *
   * @param \DateTime $createdAt
   *
   * @return User
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
   * @return User
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
   * Set firstname
   *
   * @param string $firstname
   *
   * @return User
   */
  public function setFirstname($firstname) {
    $this->firstname = $firstname;

    return $this;
  }

  /**
   * Get firstname
   *
   * @return string
   */
  public function getFirstname() {
    return $this->firstname;
  }

  /**
   * Set lastname
   *
   * @param string $lastname
   *
   * @return User
   */
  public function setLastname($lastname) {
    $this->lastname = $lastname;

    return $this;
  }

  /**
   * Get lastname
   *
   * @return string
   */
  public function getLastname() {
    return $this->lastname;
  }

}
