<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FourPixelsBundle\Listener;

/**
 * Description of AuthenticationSuccessListener
 *
 * @author asus
 */
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\HttpKernel\Log\NullLogger;
use Psr\Log\LoggerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface {

  private $router;
  private $session;
  private $context;

  /**
   * @var LoggerInterface 
   */
  protected $logger;

  /**
   * @var EventDispatcherInterface 
   */
  protected $dispatcher;

  /**
   * @var JWTManager 
   */
  protected $jwtManager;

  public function __construct(RouterInterface $router, Session $session, SecurityContextInterface $context, LoggerInterface $logger, JWTManager $jwtManager, EventDispatcherInterface $event_dispatcher) {
    $this->router = $router;
    $this->session = $session;
    $this->context = $context;
    $this->logger = $logger === null ? new NullLogger() : $logger;
    $this->dispatcher = $event_dispatcher;
    $this->jwtManager = $jwtManager;
  }

  /**
   * onAuthenticationSuccess
   *
   * @author     Joe Sexton <joe@webtipblog.com>
   * @param     Request $request
   * @param     TokenInterface $token
   * @return     Response
   */
  public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
    $this->logger->info("HEY !!!");
    if (!$token->getUser()->getUsername()) { //if user doesn't have username redirect to form
      $this->logger->info("NNOOO !!!");
      $accessToken = $token->getUser()->getAccessToken();
      $this->logger->info($accessToken);
      $this->context->setToken(null);
      $request->getSession()->invalidate();
      $redirectUrl = "/api/connect";
      return new RedirectResponse($redirectUrl);
    }
    // if AJAX login
    if ($request->isXmlHttpRequest()) {
      $this->logger->info("AJAX !!!");

      $array = array('success' => true); // data to return via JSON
      $response = new Response(json_encode($array));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

      // if form login 
    } else {
      $this->logger->info("YEAP !!!");

      if ($this->session->get('_security.main.target_path')) {
        $this->logger->info("secu !!!");

        $url = $this->session->get('_security.main.target_path');
      } else {
        $this->logger->info("welcome !!!");
        $tokenArray = $this->refreshToken($token->getUser(), $request);
        $this->logger->info(json_encode($tokenArray));
        $url = $this->router->generate('api_home');
      } // end if

      return new RedirectResponse($url);
    }
  }

  /**
   * onAuthenticationFailure
   *
   * @author     Joe Sexton <joe@webtipblog.com>
   * @param     Request $request
   * @param     AuthenticationException $exception
   * @return     Response
   */
  public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
    // if AJAX login
    if ($request->isXmlHttpRequest()) {

      $array = array('success' => false, 'message' => $exception->getMessage()); // data to return via JSON
      $response = new Response(json_encode($array));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

      // if form login 
    } else {

      // set authentication exception to session
      $request->getSession()->set(SecurityContextInterface::AUTHENTICATION_ERROR, $exception);

      return new RedirectResponse($this->router->generate('login_route'));
    }
  }

  protected function refreshToken($user, $request) {
    $this->logger->info(get_class($user));
    $jwtManager = $this->jwtManager;
    $dispatcher = $this->dispatcher;
    $jwt = $jwtManager->create($user);
    $response = new \Symfony\Component\HttpFoundation\JsonResponse();
    $event = new \Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent(array('token' => $jwt), $user, $request, $response);
    $dispatcher->dispatch(\Lexik\Bundle\JWTAuthenticationBundle\Events::AUTHENTICATION_SUCCESS, $event);
    $tokenArray = $event->getData();
    $response->setData($tokenArray);
    return $tokenArray;
  }

}
