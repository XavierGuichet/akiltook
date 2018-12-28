<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
  /**
   * @var KernelInterface
   */
  private $kernel;

  /**
   * @var Response|null
   */
  private $response;

  public function __construct()
  {
  }
  
  /**
   * @Given I am connected
   */
  public function iAmConnected()
  {
      throw new PendingException();
  }

  /**
   * @Given There is a match with id :arg1
   */
  public function thereIsAMatchWithId($arg1)
  {
      throw new PendingException();
  }

}
