# features/books.feature
Feature: Manage games
  In order to manage games
  As a user
  I need to be able to retrieve, create, update and delete them through the API.

  # the "@createSchema" annotation provided by API Platform creates a temporary SQLite database for testing the API
 @createSchema
 @login
 Scenario: Create a game
   Given There are "2" teams
   When I add "Content-Type" header equal to "application/ld+json"
   And I add "Accept" header equal to "application/ld+json"
   And I send a "POST" request to "/games" with body:
   """
   {
     "location": "Trocardière",
     "atHome": true,
     "Team1": "/teams/1",
     "Team2": "/teams/2",
     "startAt": "2018-12-01T00:00:00+01:00"
   }
   """
   Then the response status code should be 201
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
     "@context": "/contexts/Game",
     "@id": "/games/1",
     "@type": "Game",
     "id": 1,
     "atHome": true,
     "location": "Trocardière",
     "Team1": "/teams/1",
     "Team2": "/teams/2",
     "startAt": "2018-12-01T00:00:00+01:00",
     "tooks": []
   }
   """

 @login
 Scenario: Retrieve the games list
   When I add "Accept" header equal to "application/ld+json"
   And I send a "GET" request to "/games?orderstartAt=asc"
   Then the response status code should be 200
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
     "@context": "/contexts/Game",
     "@id": "/games",
     "@type": "hydra:Collection",
     "hydra:member": [
       {
         "@id": "/games/1",
         "@type": "Game",
         "id": 1,
         "atHome": true,
         "location": "Trocardière",
         "Team1": "/teams/1",
         "Team2": "/teams/2",
         "startAt": "2018-12-01T00:00:00+01:00",
         "tooks": []
       }
     ],
     "hydra:totalItems": 1
   }
   """



 # The "@dropSchema" annotation must be added on the last scenario of the feature file to drop the temporary SQLite database
 @dropSchema
 @login
   Scenario: Delete a Game
     When I add "Content-Type" header equal to "application/ld+json"
     When I add "Accept" header equal to "application/ld+json"
     And I send a "DELETE" request to "/games/1"
     Then the response status code should be 204
