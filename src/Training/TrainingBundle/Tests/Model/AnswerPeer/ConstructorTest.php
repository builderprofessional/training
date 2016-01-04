<?php
namespace Training\TrainingBundle\Tests\Model\AnswerPeer;

use Training\TrainingBundle\Model\AnswerPeer;

use Engine\EngineBundle\Model\DocumentProperty;

use ThirdEngine\Factory\Factory;

use Symfony\Bundle\FrameworkBundle\Tests;


class ConstructorTest extends Tests\TestCase
{
  public function testConstructSetsOneDocumentProperty()
  {
    $answerPeer = new AnswerPeer();

    $this->assertInstanceOf(DocumentProperty::class, $answerPeer->documentProperties[0]);
    $this->assertEquals(1, count($answerPeer->documentProperties));
  }
}