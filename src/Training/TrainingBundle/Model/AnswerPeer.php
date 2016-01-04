<?php
/**
 * This class represents an answer to a question submitted on a training course by a customer.
 *
 * @copyright 2016 Third Engine Software
 */
namespace Training\TrainingBundle\Model;


use Training\TrainingBundle\Model\om\BaseAnswerPeer;

use Engine\EngineBundle\Model\DocumentProperty;

use ThirdEngine\Factory\Factory;


class AnswerPeer extends BaseAnswerPeer
{
  /**
   * This definition will allow the document property that holds answer text to come out through PropelSOA.
   *
   * @var array
   */
  public $linkedData = [
    'AnswerText' => 'getAnswer',
  ];


  /**
   * This constructor will set up the answer as a document property to be stored in Mongo.
   */
  public function __construct()
  {
    $answerDocumentProperty = Factory::createNewObject(DocumentProperty::class, ['answer', 'getAnswer', 'setAnswer', $this]);
    $this->documentProperties = [$answerDocumentProperty];
  }
}
