# features/books.feature
Feature: Register and log
  In order to use akiltook
  As a player
  I need to be able to create an account and connect to Akiltook

  # the "@createSchema" annotation provided by API Platform creates a temporary SQLite database for testing the API
  @createSchema
  Scenario: Create an account
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/register" with body:
    """
    {
      "email": "testaccount@akiltook.fr",
      "password": "abcdef123",
      "repeatpassword": "abcdef123"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
      "message": "Votre compte a été crée"
    }
    """
  
  # The "@dropSchema" annotation must be added on the last scenario of the feature file to drop the temporary SQLite database
  @dropSchema
  Scenario: Connect to akiltook
    When I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/login"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
      "message": "Connection réussi"
    }
    """