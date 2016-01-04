<?php
namespace Training\TrainingBundle\Tests\Model\QuestionPeer;

use Training\TrainingBundle\Model\QuestionPeer;

use Engine\EngineBundle\Model\DocumentProperty;

use ThirdEngine\Factory\Factory;

use Symfony\Bundle\FrameworkBundle\Tests;


class ConstructorTest extends Tests\TestCase
{
  public function testConstructSetsOneDocumentProperty()
  {
    $questionPeer = new QuestionPeer();

    $this->assertInstanceOf(DocumentProperty::class, $questionPeer->documentProperties[0]);
    $this->assertEquals(1, count($questionPeer->documentProperties));
  }
}