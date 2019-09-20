<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behatch\Context\RestContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;


use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;

use App\Entity\Account;
use App\Entity\Club;
use App\Entity\Game;
use App\Entity\Team;
/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
  /**
   * @var ManagerRegistry
   */
  private $doctrine;
  /**
   * @var SchemaTool
   */
  private $schemaTool;
  /**
   * @var array
   */
  private $classes;
  /**
   * @var
   */
  private $manager;
  /**
   * @var
   */
  private $jwtManager;

  public function __construct(ManagerRegistry $doctrine, $jwtManager)
  {
      $this->doctrine = $doctrine;
      $this->jwtManager = $jwtManager;
      $this->manager = $doctrine->getManager();
      $this->schemaTool = new SchemaTool($this->manager);
      $this->classes = $this->manager->getMetadataFactory()->getAllMetadata();
  }

  /**
   * @BeforeScenario @createSchema
   */
  public function createDatabase()
  {
      $this->schemaTool->dropSchema($this->classes);
      $this->doctrine->getManager()->clear();
      $this->schemaTool->createSchema($this->classes);
  }

  /**
   * @BeforeScenario @login
   *
   * @see https://symfony.com/doc/current/security/entity_provider.html#creating-your-first-user
   */
  public function login(BeforeScenarioScope $scope)
  {
      if(!$user = $this->manager->getRepository(Account::class) ->find(1)) {
        $user = new Account();
        $user->setUsername('testaccount');
        $user->setPassword('ATestPassword');
        $user->setEmail('test@test.com');

        $this->manager->persist($user);
        $this->manager->flush();
      }

      $token = $this->jwtManager->create($user);

      $this->restContext = $scope->getEnvironment()->getContext(RestContext::class);
      $this->restContext->iAddHeaderEqualTo('Authorization', "Bearer $token");
  }

  /**
   * @AfterScenario @logout
   */
  public function logout() {
      $this->restContext->iAddHeaderEqualTo('Authorization', '');
  }

  /**
   * @Given I am connected
   */
  public function iAmConnected()
  {
      throw new PendingException();
  }

  /**
   * @Given There is a game with id :arg1
   */
  public function thereIsAGameWithId($arg1)
  {
    $manager = $this->doctrine->getManager();

    $club = new Club();
    $club->setName("AEPR");
    $manager->persist($club);

    $team1 = new Team();
    $team1->setName('Feminine A');
    $team1->setClub($club);
    $manager->persist($team1);

    $team2 = new Team();
    $team2->setName('Feminine B');
    $team2->setClub($club);
    $manager->persist($team2);


    $game = new Game();
    $game->setTeam1($team1);
    $game->setTeam2($team2);
    $manager->persist($game);

    $manager->flush();
  }

  /**
   * @Given There is a club with id :arg1
   */
  public function thereIsAClubWithId($arg1)
  {
      $club = new Club();
      $club->setName("AEPR");

      $manager = $this->doctrine->getManager();
      $manager->persist($club);
      $manager->flush();
  }

  /**
   * @Given There are :arg1 teams
   */
  public function thereAreTeams($arg1)
  {
      $manager = $this->doctrine->getManager();

      $club = new Club();
      $club->setName("AEPR");
      $manager->persist($club);
      for($i = 0;  $i < $arg1; $i++) {
        $team = new Team();
        $team->setName('Feminine A');
        $team->setClub($club);
        $manager->persist($team);
      }
      $manager->flush();
  }

  /**
   * @Given It is pending
   */
  public function itIsPending()
  {
      throw new PendingException();
  }

}
