<?php
/**
 * This class defines the notification to be sent to someone who just signed up for BuilderTraining.net. This
 * email will guide them to the right place and confirm that their email is valid.
 *
 * @copyright 2015 Third Engine Software
 */
namespace Training\TrainingBundle\Notification;

use Engine\BillingBundle\Model\Signup;
use Engine\EngineBundle\Base\Notification;
use Engine\EngineBundle\Base\EmailNotification;


class SignupConfirmation extends Notification
{
  use EmailNotification;


  /**
   * @var Signup
   */
  protected $signup;

  /**
   * @var string
   */
  protected $textTemplatePath = 'TrainingTrainingBundle:EmailNotification:signupConfirmation.text.twig';

  /**
   * @var string
   */
  protected $htmlTemplatePath = 'TrainingTrainingBundle:EmailNotification:signupConfirmation.html.twig';


  /**
   * @param Signup $signup
   */
  public function __construct(Signup $signup)
  {
    $this->signup = $signup;

    $this->setupStandardTokenDefinitions();
    $this->addAdditionalTokens();
  }

  /**
   * This method will add additional tokens that should be supported for this notification.
   */
  protected function addAdditionalTokens()
  {
    $this->tokenDefinitions['RECIPIENT_NAME'] = function()
    {
      return $this->signup->getName();
    };

    $this->tokenDefinitions['TOKEN'] = function()
    {
      return $this->signup->getBypassToken()->getToken();
    };
  }

  /**
   * @return string
   */
  protected function subject()
  {
    return 'Finish Signing Up for BuilderTraining.net';
  }

  /**
   * @return string
   */
  public function getToEmail()
  {
    return $this->signup->getEmail();
  }
}