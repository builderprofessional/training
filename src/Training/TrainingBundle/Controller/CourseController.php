<?php
/**
 * This controller exposes courses to the training app.
 *
 * @copyright 2016 Third Engine Software
 */
namespace Training\TrainingBundle\Controller;


use Training\TrainingBundle\Model\Course;

use Engine\EngineBundle\Controller\ModelBasedController;

use ThirdEngine\Factory\Factory;
use ThirdEngine\PropelSOABundle\Http\PropelSOAErrorResponse;
use ThirdEngine\PropelSOABundle\Http\PropelSOASuccessResponse;
use ThirdEngine\PropelSOABundle\Base\SymfonyClassInfo;
use ThirdEngine\PropelSOABundle\Interfaces\Collectionable;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @route /training/course
 */
class CourseController extends ModelBasedController implements Collectionable
{
  /**
   * This method points our controller to the proper table.
   */
  public function setupClassInfo()
  {
    $this->classInfo = new SymfonyClassInfo();

    $this->classInfo->namespace = 'Training';
    $this->classInfo->bundle    = 'Training';
    $this->classInfo->entity    = 'Course';
  }

  /**
   * This action will return a list of clients.
   *
   * @route /public/training/course
   *
   * @Route("/course")
   * @Method({"GET"})
   *
   * @param Request $request
   */
  public function getAction(Request $request)
  {
    return parent::getAction($request);
  }
}