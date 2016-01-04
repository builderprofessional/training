<?php
/**
 * This controller provides a service to sign up for BuilderTraining.net, yay!
 *
 * @copyright 2016 Third Engine Software
 */
namespace Training\TrainingBundle\Controller;


use Training\TrainingBundle\Notification\SignupConfirmation;

use Engine\BillingBundle\Controller\SignupController as BillingSignupController;
use Engine\BillingBundle\Model\Signup;
use Engine\BillingBundle\Model\SignupQuery;
use Engine\AuthBundle\Model\BypassTokenQuery;

use ThirdEngine\Factory\Factory;
use ThirdEngine\PropelSOABundle\Http\PropelSOAErrorResponse;
use ThirdEngine\PropelSOABundle\Http\PropelSOASuccessResponse;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @route /training/signup
 */
class SignupController extends BillingSignupController
{
  /**
   * This action will start the signup process.
   *
   * @Route("signup/json")
   * @Method({"POST"})
   *
   * @param Request $request
   */
  public function postAction(Request $request)
  {
    return parent::postAction($request);
  }

  /**
   * This action will start the signup process, but will behave like a normal API call, it will not handle
   * a standard form post.
   *
   * @Route("signup/json")
   * @Method({"POST"})
   *
   * @param Request $request
   */
  public function signupAction(Request $request)
  {
    return parent::signupAction($request);
  }

  /**
   * This action will complete the signup process and create a billing client.
   *
   * @Route("/signup/complete")
   * @Method({"POST"})
   *
   * @param Request $request
   */
  public function completeAction(Request $request)
  {
    return parent::completeAction($request);
  }

  /**
   * This action will find a signup record based on the associated token.
   *
   * @Route("/signup/findByToken/{token}")
   * @Method({"GET"})
   *
   * @param Request $request
   */
  public function findByTokenAction($token, Request $request)
  {
    $bypassToken = Factory::createNewQueryObject(BypassTokenQuery::class)->findOneByToken($token);

    if ($bypassToken == null)
    {
      $errorResponse = new PropelSOAErrorResponse('That token could not be found. Please try the signup again.', 404);
      return $errorResponse;
    }

    $signup = Factory::createNewQueryObject(SignupQuery::class)->findOneByAuthBypassTokenId($bypassToken->getBypassTokenId());

    if ($signup == null)
    {
      $errorResponse = new PropelSOAErrorResponse('We could not find a record of your signup. Please try the signup again.', 404);
      return $errorResponse;
    }

    $signupData = [
      'SignupId' => $signup->getSignupId(),
      'Name' => $signup->getName(),
      'Email' => $signup->getEmail(),
    ];

    return new PropelSOASuccessResponse($signupData);
  }

  /**
   * This method will send the notification out to allow someone to convert from a signup to a
   * billing client for the training system.
   *
   * @param Signup $signup
   */
  protected function notify(Signup $signup)
  {
    $signupNotification = Factory::createNewObject(SignupConfirmation::class, [$signup]);
    $signupNotification->send();
  }
}