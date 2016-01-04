<?php
namespace Training\TrainingBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
class DefaultController extends Controller
{
  public function indexAction()
  {
    return $this->render('TrainingTrainingBundle:Default:index.html.twig');
  }
  public function signupAction()
  {
    return $this->render('TrainingTrainingBundle:Default:signup.html.twig');
  }
}