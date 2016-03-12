<?php
namespace Training\TrainingBundle\Tests\Notification;


use Training\TrainingBundle\Notification\NewQuestion;
use Training\TrainingBundle\Model\Question;

use Engine\AuthBundle\Model\User;
use Engine\DemographicBundle\Model\Person;
use Engine\DemographicBundle\Model\Company;
use Engine\DemographicBundle\Model\Employee;
use Engine\EngineBundle\Tests\NotificationTestCase;

use ThirdEngine\PropelSOABundle\Tests\TestUtility;


class NewQuestionTest extends NotificationTestCase
{
  public function testGetSubjectReturnsCorrectValue()
  {
    $question = new Question();
    $notification = new NewQuestion($question);

    $this->assertEquals('New Customer Question Asked', $notification->getSubject());
  }

  public function testGetToEmailReturnsSupportList()
  {
    $question = new Question();
    $notification = new NewQuestion($question);

    $this->assertEquals('support@builderprofessional.com', $notification->getToEmail());
  }

  public function testAdditionalTokensReturnCorrectValues()
  {
    $firstName = 'Tony';
    $lastName = 'Vance';
    $companyName = 'Umbrella Corporation';
    $email = 'tony.vance@builderprofessional.com';
    $questionText = 'Yo, I have a question';


    $company = new Company();
    $company->setName($companyName);

    $employee = new Employee();
    $employee->setCompany($company);

    $personMock = $this->getMock(Person::class, ['getEmployee', 'getPrimaryEmailAddress']);
    $personMock->expects($this->any())
      ->method('getEmployee')
      ->willReturn($employee);
    $personMock->expects($this->any())
      ->method('getPrimaryEmailAddress')
      ->willReturn($email);

    $personMock->setFirstName($firstName);
    $personMock->setLastName($lastName);

    $user = new User();
    $user->setPerson($personMock);

    $question = $this->getMock(Question::class, ['getQuestion']);
    $question->expects($this->any())
      ->method('getQuestion')
      ->willReturn($questionText);

    $question->setUser($user);

    $newQuestionNotification = new NewQuestion($question);

    $this->assertTokenValue('Tony Vance', $newQuestionNotification, 'CUSTOMER_NAME');
    $this->assertTokenValue($companyName, $newQuestionNotification, 'COMPANY_NAME');
    $this->assertTokenValue($email, $newQuestionNotification, 'EMAIL_ADDRESS');
    $this->assertTokenValue($questionText, $newQuestionNotification, 'QUESTION');
  }
}