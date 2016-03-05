<?php
/**
 * This controller exposes answers to questions to the training app.
 *
 * @copyright 2016 Third Engine Software
 */
namespace Training\TrainingBundle\Controller;


use Training\TrainingBundle\Model\Answer;

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
 * @route /training/answer
 */
class AnswerController extends ModelBasedController implements Collectionable
{
  /**
   * This method points our controller to the proper table.
   */
  public function setupClassInfo()
  {
    $this->classInfo = new SymfonyClassInfo();

    $this->classInfo->namespace = 'Training';
    $this->classInfo->bundle    = 'Training';
    $this->classInfo->entity    = 'Answer';
  }

  /**
   * This action will return a list of answers.
   *
   * @Route("/answer")
   * @Method({"GET"})
   *
   * @param Request $request
   */
  public function getAction(Request $request)
  {
    return parent::getAction($request);
  }

  /**
   * This action will submit the answer to a course question
   *
   * @Route("/answer")
   * @Method({"POST"})
   *
   * @param Request $request
   */
  public function postAction(Request $request)
  {
    return parent::postAction($request);
  }

  /**
   * This method will get a model object that is populated with the data from the post. We are overriding this
   * method in order to set the user ID to the currently logged in user.
   *
   * @param Request $request
   * @return Answer
   */
  protected function getObjectFromRequest(Request $request)
  {
    $answer = parent::getObjectFromRequest($request);

    $user = $this->get('Session')->get('userRecord');
    $answer->setAuthUserId($user->getUserId());

    return $answer;
  }

  /**
   * This method will make sure the actual answer text will get sent to Mongo for us to remember.
   *
   * @param Request $request
   * @param Answer $answer
   */
  protected function afterSave(Answer $answer)
  {
    $request = $this->getRequest();
    $post = json_decode($request->getContent());

    $answer->setAnswer($post->AnswerText);
    $answer->save();

    return $answer;
  }
}