<?php
/**
 * This class represents a query to pull questions from the database. Note that most of the
 * actual question data is actually in Mongo.
 *
 * @copyright 2016 Third Engine Software
 */
namespace Training\TrainingBundle\Model;


use Training\TrainingBundle\Model\om\BaseQuestionQuery;

use Engine\AuthBundle\Model\UserQuery;

use ThirdEngine\Factory\Factory;



class QuestionQuery extends BaseQuestionQuery
{
  /**
   * This method will filter our query results to a particular billing client ID.
   *
   * @param int $clientId
   * @return QuestionQuery
   */
  public function filterByClientId($clientId)
  {
    $userIds = [];
    $users = Factory::createNewQueryObject(UserQuery::class)->findByBillingClientId($clientId);

    foreach ($users as $user)
    {
      $userIds[] = $user->getUserId();
    }

    return $this->filterByAuthUserId($userIds);
  }
}
