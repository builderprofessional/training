<?php
namespace Training\TrainingBundle\Tests\Model\Course;

use Training\TrainingBundle\Model\Course;

use Engine\BillingBundle\Model\ClientPeer;
use Engine\BillingBundle\Model\ClientQuery;
use Engine\BillingBundle\Model\ClientProduct;
use Engine\BillingBundle\Model\Product;

use ThirdEngine\Factory\Factory;

use Symfony\Bundle\FrameworkBundle\Tests;


class IsAuthorizedTest extends Tests\TestCase
{
  public function testIsAuthorizedReturnsTrueWhenCourseWasDirectlyPurchased()
  {
    $courseProductId = 33;
    $courseCode = 'MYCOURSE';
    $clientId = 15;

    $clientPeerMock = $this->getClientPeerMock($clientId);
    $clientProductMock = $this->getClientProductMock($courseProductId, $courseCode);
    $clientQueryMock = $this->getClientQueryMock($clientId, [$clientProductMock]);

    Factory::injectObject(ClientPeer::class, $clientPeerMock);
    Factory::injectQueryObject(ClientQuery::class, $clientQueryMock);

    $course = new Course();
    $course->setBillingProductId($courseProductId);

    $this->assertEquals(1, $course->isAuthorized());
  }

  public function testIsAuthorizedReturnsTrueWhenClientOnNeverStopLearningPlan()
  {
    $courseProductId = 33;
    $courseCode = 'MYCOURSE';
    $clientId = 15;

    $neverStopLearningProductId = 34;
    $neverStopLearningCode = 'NEVER_STOP_LEARNING';

    $clientPeerMock = $this->getClientPeerMock($clientId);
    $clientProductMock = $this->getClientProductMock($neverStopLearningProductId, $neverStopLearningCode);
    $clientQueryMock = $this->getClientQueryMock($clientId, [$clientProductMock]);

    Factory::injectObject(ClientPeer::class, $clientPeerMock);
    Factory::injectQueryObject(ClientQuery::class, $clientQueryMock);

    $course = new Course();
    $course->setBillingProductId($courseProductId);

    $this->assertEquals(1, $course->isAuthorized());
  }

  public function testIsAuthorizedReturnsFalseWhenClientHasDifferentCourse()
  {
    $courseProductId = 33;
    $courseCode = 'MYCOURSE';
    $clientId = 15;

    $otherCourseProductId = 35;
    $otherCourseCode = 'OTHERCOURSE';

    $clientPeerMock = $this->getClientPeerMock($clientId);
    $clientProductMock = $this->getClientProductMock($otherCourseProductId, $otherCourseCode);
    $clientQueryMock = $this->getClientQueryMock($clientId, [$clientProductMock]);

    Factory::injectObject(ClientPeer::class, $clientPeerMock);
    Factory::injectQueryObject(ClientQuery::class, $clientQueryMock);

    $course = new Course();
    $course->setBillingProductId($courseProductId);

    $this->assertEquals(0, $course->isAuthorized());
  }

  public function testIsAuthorizedReturnsTrueWhenClientIdIsNull()
  {
    $clientPeerMock = $this->getClientPeerMock(null);
    Factory::injectObject(ClientPeer::class, $clientPeerMock);

    $course = new Course();
    $this->assertTrue($course->isAuthorized());
  }

  protected function getClientPeerMock($clientId)
  {
    $clientPeerMock = $this->getMock(ClientPeer::class, ['getWorkingClientId']);
    $clientPeerMock->expects($this->any())
      ->method('getWorkingClientId')
      ->willReturn($clientId);

    return $clientPeerMock;
  }

  protected function getClientProductMock($productId, $productCode)
  {
    $productMock = $this->getMock(Product::class, ['getCode']);
    $productMock->expects($this->any())
      ->method('getCode')
      ->willReturn($productCode);

    $clientProductMock = $this->getMock(ClientProduct::class, ['getProductId', 'getProduct']);
    $clientProductMock->expects($this->any())
      ->method('getProductId')
      ->willReturn($productId);
    $clientProductMock->expects($this->any())
      ->method('getProduct')
      ->willReturn($productMock);

    return $clientProductMock;
  }

  protected function getClientQueryMock($clientId, array $clientProducts)
  {
    $clientMock = $this->getMock(Client::class, ['getClientProducts']);
    $clientMock->expects($this->any())
      ->method('getClientProducts')
      ->willReturn($clientProducts);

    $clientQueryMock = $this->getMock(ClientQuery::class, ['findOneByClientId']);
    $clientQueryMock->expects($this->any())
      ->method('findOneByClientId')
      ->with($this->equalTo($clientId))
      ->willReturn($clientMock);

    return $clientQueryMock;
  }
}