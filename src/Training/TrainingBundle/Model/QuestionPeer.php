<?php
/**
 * This class defines a question asked about a training course.
 */
namespace Training\TrainingBundle\Model;


use Training\TrainingBundle\Model\om\BaseQuestionPeer;

use Engine\EngineBundle\Model\DocumentProperty;

use ThirdEngine\Factory\Factory;


class QuestionPeer extends BaseQuestionPeer
{
  /**
   * This definition will allow the document property that holds question text to come out through PropelSOA.
   *
   * @var array
   */
  public $linkedData = [
    'QuestionText' => 'getQuestion',
  ];


  /**
   * This constructor will set us up to store our question text in MongoDB.
   */
  public function __construct()
  {
    $questionDocumentProperty = Factory::createNewObject(DocumentProperty::class, ['question', 'getQuestion', 'setQuestion', $this]);
    $this->documentProperties = [$questionDocumentProperty];
  }
}
