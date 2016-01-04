<?php
/**
 * This controller exposes questions to the training app.
 *
 * @copyright 2016 Third Engine Software
 */
namespace Training\TrainingBundle\Controller;


use Training\TrainingBundle\Model\Question;

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
 * @route /training/question
 */
class QuestionController extends ModelBasedController implements Collectionable
{
  /**
   * This method points our controller to the proper table.
   */
  public function setupClassInfo()
  {
    $this->classInfo = new SymfonyClassInfo();

    $this->classInfo->namespace = 'Training';
    $this->classInfo->bundle    = 'Training';
    $this->classInfo->entity    = 'Question';
  }

  /**
   * This action will return a list of clients.
   *
   * @Route("/question")
   * @Method({"GET"})
   *
   * @param Request $request
   */
  public function getAction(Request $request)
  {
    return parent::getAction($request);
  }

  /**
   * This action will start the signup process.
   *
   * @Route("/question")
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
   * @return Question
   */
  protected function getObjectFromRequest(Request $request)
  {
    $question = parent::getObjectFromRequest($request);

    $user = $this->get('Session')->get('userRecord');
    $question->setAuthUserId($user->getUserId());

    return $question;
  }

  /**
   * This method will make sure the actual question text will get sent to Mongo for us to remember.
   *
   * @param Request $request
   * @param Question $question
   */
  protected function afterSave(Question $question)
  {
    $request = $this->getRequest();
    $post = json_decode($request->getContent());

    $question->setQuestion($post->Question);
    $question->save();

    return $question;
  }
}