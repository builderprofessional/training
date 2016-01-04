<?php
namespace Training\TrainingBundle\Tests\Notification;

use Training\TrainingBundle\Notification\SignupConfirmation;

use Engine\BillingBundle\Model\Signup;
use Engine\AuthBundle\Model\BypassToken;

use ThirdEngine\PropelSOABundle\Tests\TestUtility;

use Symfony\Bundle\FrameworkBundle\Tests;


class SignupConfirmationTest extends Tests\TestCase
{
  public function testConstructorSetsUpTokens()
  {
    $signup = new Signup();
    $testUtility = new TestUtility();

    $notification = new SignupConfirmation($signup);
    $tokens = $testUtility->getProtectedProperty($notification, 'tokenDefinitions');

    $this->assertTrue(isset($tokens['RECIPIENT_NAME']));
    $this->assertTrue(isset($tokens['TOKEN']));
  }

  public function testSubjectReturnsString()
  {
    $signup = new Signup();
    $testUtility = new TestUtility();

    $notification = new SignupConfirmation($signup);
    $subject = $testUtility->callProtectedMethod($notification, 'subject');

    $this->assertEquals('string', gettype($subject));
  }

  public function testGetToEmailReturnsEmailFromSignup()
  {
    $email = 'someone@somewhere.com';

    $signupMock = $this->getMock(Signup::class, ['getEmail']);
    $signupMock->expects($this->any())
      ->method('getEmail')
      ->willReturn($email);

    $notification = new SignupConfirmation($signupMock);
    $this->assertEquals($email, $notification->getToEmail());
  }

  public function testRecipientNameReturnsSignupName()
  {
    $name = 'Tony Vance';

    $signupMock = $this->getMock(Signup::class, ['getName']);
    $signupMock->expects($this->any())
      ->method('getName')
      ->willReturn($name);

    $testUtility = new TestUtility();
    $notification = new SignupConfirmation($signupMock);
    $tokens = $testUtility->getProtectedProperty($notification, 'tokenDefinitions');

    $recipientNameCallback = $tokens['RECIPIENT_NAME'];
    $this->assertEquals($name, $recipientNameCallback());
  }

  public function testTokenReturnsBypassTokenValue()
  {
    $token = 'aaasdf';

    $bypassTokenMock = $this->getMock(BypassToken::class, ['getToken']);
    $bypassTokenMock->expects($this->any())
      ->method('getToken')
      ->willReturn($token);

    $signupMock = $this->getMock(Signup::class, ['getBypassToken']);
    $signupMock->expects($this->any())
      ->method('getBypassToken')
      ->willReturn($bypassTokenMock);

    $testUtility = new TestUtility();
    $notification = new SignupConfirmation($signupMock);
    $tokens = $testUtility->getProtectedProperty($notification, 'tokenDefinitions');

    $tokenCallback = $tokens['TOKEN'];
    $this->assertEquals($token, $tokenCallback());
  }
}