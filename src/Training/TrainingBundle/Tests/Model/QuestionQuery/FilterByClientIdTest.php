<?php
namespace Training\TrainingBundle\Tests\Model\QuestionQuery;


use Training\TrainingBundle\Model\QuestionQuery;

use Engine\AuthBundle\Model\UserQuery;
use Engine\AuthBundle\Model\User;

use ThirdEngine\Factory\Factory;

use PropelCollection;
use Symfony\Bundle\FrameworkBundle\Tests;


class FilterByClientIdTest extends Tests\TestCase
{
  public function testFilterByClientIdLimitsByRelatedUserIds()
  {
    $clientId = 8828;
    $userId1 = 299382;
    $userId2 = 111883;

    $userMock1 = $this->getUserMock($userId1);
    $userMock2 = $this->getUserMock($userId2);

    $userCollection = new PropelCollection();
    $userCollection->setData([$userMock1, $userMock2]);

    $userQueryMock = $this->getMock(UserQuery::class, ['findByBillingClientId']);
    $userQueryMock->expects($this->any())
      ->method('findByBillingClientId')
      ->with($this->equalTo($clientId))
      ->willReturn($userCollection);

    Factory::injectQueryObject(UserQuery::class, $userQueryMock);

    $query = $this->getMock(QuestionQuery::class, ['filterByAuthUserId']);
    $query->expects($this->once())
      ->method('filterByAuthUserId')
      ->with($this->equalTo([$userId1, $userId2]));

    $query->filterByClientId($clientId);
  }

  protected function getUserMock($userId)
  {
    $userMock = $this->getMock(User::class, ['getUserId']);
    $userMock->expects($this->any())
      ->method('getUserId')
      ->willReturn($userId);

    return $userMock;
  }
}