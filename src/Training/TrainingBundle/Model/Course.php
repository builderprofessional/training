<?php
/**
 * This represents one training course.
 *
 * @copyright 2016 Third Engine Software
 */
namespace Training\TrainingBundle\Model;


use Training\TrainingBundle\Model\om\BaseCourse;

use Engine\BillingBundle\Model\ClientPeer;
use Engine\BillingBundle\Model\ClientQuery;

use ThirdEngine\Factory\Factory;


class Course extends BaseCourse
{
  /**
   * This method will determine if the current client or user has access to view our materials.
   *
   * @return int
   */
  public function isAuthorized()
  {
    $clientPeer = Factory::createNewObject(ClientPeer::class);
    $clientId = $clientPeer->getWorkingClientId();

    if ($clientId === null)
    {
      return true;
    }

    $client = Factory::createNewQueryObject(ClientQuery::class)->findOneByClientId($clientId);
    foreach ($client->getClientProducts() as $clientProduct)
    {
      if ($clientProduct->getProductId() == $this->getBillingProductId())
      {
        // Our related product is in the list of products the client has access to, so they should be able to view this.
        return 1;
      }

      if ($clientProduct->getProduct()->getCode() == 'NEVER_STOP_LEARNING')
      {
        // This client is on the all-access plan, and should always have access
        return 1;
      }
    }

    return 0;
  }
}
