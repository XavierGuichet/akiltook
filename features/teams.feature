# features/books.feature
Feature: Manage Team
  In order to manage team
  As a user
  I need to be able to retrieve, create, update and delete 'teams' through the API.

  # the "@createSchema" annotation provided by API Platform creates a temporary SQLite database for testing the API
 @createSchema
 @login
 Scenario: Create a Team
   Given There is a club with id "1"
   When I add "Content-Type" header equal to "application/ld+json"
   And I add "Accept" header equal to "application/ld+json"
   And I send a "POST" request to "/teams" with body:
   """
   {
     "Name": "Feminine A",
     "club": "/clubs/1"
   }
   """
   Then the response status code should be 201
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
       "@context": "/contexts/Team",
       "@id": "/teams/1",
       "@type": "Team",
       "id": 1,
       "Name": "Feminine A",
       "games": [],
       "club": "/clubs/1"
   }
   """

 @login
 Scenario: Delete a Team
   When I add "Content-Type" header equal to "application/ld+json"
   When I add "Accept" header equal to "application/ld+json"
   And I send a "DELETE" request to "/teams/1"
   Then the response status code should be 204