# features/books.feature
Feature: Manage club
  In order to manage club
  As a user
  I need to be able to retrieve, create, update and delete 'clubs' through the API.

  # the "@createSchema" annotation provided by API Platform creates a temporary SQLite database for testing the API
 @createSchema
 @login
 Scenario: Create a Club
   # Given I am connected
   # And There is a game with id "1"
   When I add "Content-Type" header equal to "application/ld+json"
   And I add "Accept" header equal to "application/ld+json"
   And I send a "POST" request to "/clubs" with body:
   """
   {
     "Name": "AEPR"
   }
   """
   Then the response status code should be 201
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
       "@context": "/contexts/Club",
       "@id": "/clubs/1",
       "@type": "Club",
       "id": 1,
       "Name": "AEPR",
       "teams": []
   }
   """
   
 @login
 Scenario: Delete a Club
   When I add "Content-Type" header equal to "application/ld+json"
   When I add "Accept" header equal to "application/ld+json"
   And I send a "DELETE" request to "/clubs/1"
   Then the response status code should be 204