<?php

/**
 * Description of FOSUBUserProvider
 *
 * @author Rene Roberto Ramirez Szabo <rene.szabo@gmail.com>
 */

namespace FourPixelsBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpKernel\Log\NullLogger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncode;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class FOSUBUserProvider extends BaseClass {

  /**
   * @var LoggerInterface 
   */
  protected $logger;
  protected $securityPasswordEncoder;

  /**
   * @var EventDispatcherInterface 
   */
  protected $dispatcher;


  /**
   * Constructor.
   *
   * @param UserManagerInterface $userManager FOSUB user provider.
   * @param array                $properties  Property mapping.
   */
  public function __construct(UserManagerInterface $userManager, array $properties, $s, EventDispatcherInterface $event_dispatcher, LoggerInterface $logger) {
    $this->securityPasswordEncoder = $s;
    $this->dispatcher = $event_dispatcher;
    $this->logger = $logger === null ? new NullLogger() : $logger;
    return parent::__construct($userManager, $properties);
  }

  /**
   * {@inheritDoc}
   */
  public function connect(UserInterface $user, UserResponseInterface $response) {
    $this->logger->info("connect");
    parent::connect($user, $response);
  }

  /**
   * {@inheritdoc}
   */
  public function loadUserByUsername($username) {
    $this->logger->info("loadUserByUsername");
    return parent::loadUserByUsername($username);
  }

  /**
   * {@inheritdoc}
   */
  public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
    /* @var $response \HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse */
    /* @var $ro \HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface */
    /* @var $user \EntityBundle\Document\User */
    $this->logger->info("loadUserByOAuthUserResponse");
    $ro = $response->getResourceOwner();
    $username = $response->getUsername();
    $field = $this->getProperty($response);
    $user = $this->userManager->findUserBy(array($field => $username));

    //when the user is registrating 'doctrine_mongodb'
    if (null === $user) {
      $email = $response->getEmail();
      $user = $this->userManager->findUserBy(array('email' => $email));
      $isNew = false;
      if (null === $user) {
        $user = $this->userManager->createUser();
        $isNew = true;
      }

      $service = $ro->getName();
      $setter = 'set' . ucfirst($service);
      $setter_id = $setter . 'Id';
      $setter_token = $setter . 'AccessToken';
      // create new user here
      $user->$setter_id($username);
      $user->$setter_token($response->getAccessToken());
      if ($isNew) {
        //I have set all requested data with the user's username
        //modify here with relevant data
        $user->setUsername($username);
        $encoder = $this->securityPasswordEncoder;
        $passwordRandom = $this->randomPassword(10);
        $pass = $encoder->encodePassword($user, $passwordRandom);
        $user->setPassword($pass);
        $user->setEnabled(true);
        $user->setEmail($username);
        $user->addRole(\FourPixelsBundle\Entity\User::ROLE_DEFAULT);
        if ($ro instanceof \HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\GoogleResourceOwner) {
          $email = $response->getEmail();
          $firstname = $response->getFirstName();
          $lastname = $response->getLastName();
          $user->setEmail($email);
          $user->setFirstname($firstname);
          $user->setLastname($lastname);
        } else if ($ro instanceof \HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\FacebookResourceOwner) {
          $email = $response->getEmail();
          $firstname = $response->getRealName();
          $user->setEmail($response->getEmail());
          $user->setFirstname($firstname);
        }
      }
      $this->userManager->updateUser($user);
      if ($isNew) {
//        $this->dispatcher->dispatch('participaid.register.mail.event', new \MailBundle\Event\ParticipaidRegisterMailEvent($user, $passwordRandom));
      }
      return $user;
    }

    //if user exists - go with the HWIOAuth way
    $user = parent::loadUserByOAuthUserResponse($response);
    $serviceName = $response->getResourceOwner()->getName();
    $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
    //update access token 
    $user->$setter($response->getAccessToken());
    $this->logger->info("RETURN => " . $user->getEmail());
    return $user;
  }

  public function randomPassword($length) {
    $bytes = md5(uniqid(rand(), true));
    return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
  }
}
