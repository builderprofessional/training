<?php
/**
 * This notification sends a message to the support list letting everyone know that a customer question has
 * been asked.
 *
 * @copyright 2016 Third Engine Software
 */
namespace Training\TrainingBundle\Notification;


use Training\TrainingBundle\Model\Question;

use Engine\EngineBundle\Base\Notification;
use Engine\EngineBundle\Base\EmailNotification;


class NewQuestion extends Notification
{
  use EmailNotification;


  /**
   * @var string
   */
  protected $textTemplatePath = 'TrainingTrainingBundle:EmailNotification:newQuestion.text.twig';


  /**
   * @var Question
   */
  protected $question;


  /**
   * @param Question $question
   */
  public function __construct(Question $question)
  {
    $this->question = $question;

    $this->setupStandardTokenDefinitions();
    $this->addAdditionalTokens();
  }

  /**
   * This method will setup tokens specific to letting support know a new question has been asked.
   */
  protected function addAdditionalTokens()
  {
    $this->tokenDefinitions['CUSTOMER_NAME'] = function()
    {
      return $this->question->getUser()->getPerson()->getNameFirstLast();
    };

    $this->tokenDefinitions['COMPANY_NAME'] = function()
    {
      $person = $this->question->getUser()->getPerson();
      $employeeRecord = $person->getEmployee();

      return $employeeRecord !== null
        ? $employeeRecord->getCompany()->getName()
        : '';
    };

    $this->tokenDefinitions['EMAIL_ADDRESS'] = function()
    {
      return $this->question->getUser()->getPerson()->getPrimaryEmailAddress();
    };

    $this->tokenDefinitions['QUESTION'] = function()
    {
      return $this->question->getQuestion();
    };
  }

  /**
   * @return string
   */
  protected function subject()
  {
    return 'New Customer Question Asked';
  }

  /**
   * @return string
   */
  public function getToEmail()
  {
    return 'support@builderprofessional.com';
  }
}