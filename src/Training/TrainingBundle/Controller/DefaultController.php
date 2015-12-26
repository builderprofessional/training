<?php
namespace Training\TrainingBundle\Controller;

use ThirdEngine\PropelSOABundle\Http\PropelSOASuccessResponse;
use ThirdEngine\PropelSOABundle\Controller\ServiceController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * @route /training/default
 */
class DefaultController extends ServiceController
{
  /**
   * @Route("/default")
   * @Method({"GET"})
   *
   * @param Request $request
   */
  public function getAction(Request $request)
  {
    return new PropelSOASuccessResponse(['yo' => 1]);
  }
}
