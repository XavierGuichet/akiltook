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
    And I send a "POST" request to "/accounts" with body:
    """
    {
      "username": "John Doe",
      "email": "testaccount@akiltook.fr",
      "password": "abcdef123"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
        "@context": "/contexts/Account",
        "@id": "/accounts/1",
        "@type": "Account",
        "email": "testaccount@akiltook.fr",
        "roles": [
              "ROLE_USER"
        ],
        "username": "John Doe"
    }
    """
    
  Scenario: Connect to akiltook
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/login_check" with body:
    """
    {
      "email": "testaccount@akiltook.fr",
      "password": "abcdef123"
    }
    """
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the response should contain "token"  
  
  # The "@dropSchema" annotation must be added on the last scenario of the feature file to drop the temporary SQLite database
  @dropSchema 
  @login
  Scenario: Get my Data
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/accounts/me"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
        "@context": "/contexts/Account",
        "@id": "/accounts/1",
        "@type": "Account",
        "email": "testaccount@akiltook.fr",
        "roles": [
              "ROLE_USER"
        ],
        "username": "John Doe"
    }
    """