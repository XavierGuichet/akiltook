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
   And I send a "POST" request to "/sport_events" with body:
   """
   {
     "location": "Trocardière",
     "HomeTeam": "/sport_teams/1",
     "AwayTeam": "/sport_teams/2",
     "startDate": "2018-12-01T00:00:00+01:00"
   }
   """
   Then the response status code should be 201
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
     "@context": "/contexts/SportEvent",
     "@id": "/sport_events/1",
     "@type": "SportEvent",
     "HomeTeam": "/sport_teams/1",
     "AwayTeam": "/sport_teams/2",
     "Id": 1,
     "location": "Trocardière",
     "startDate": "2018-12-01T00:00:00+01:00"
  }
   """

 @login
 Scenario: Retrieve the games list
   When I add "Accept" header equal to "application/ld+json"
   And I send a "GET" request to "/sport_events?orderStartDate=asc"
   Then the response status code should be 200
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
             "@context": "/contexts/SportEvent",
             "@id": "/sport_events",
             "@type": "hydra:Collection",
             "hydra:member": [
                 {
                     "@id": "/sport_events/1",
                     "@type": "SportEvent",
                     "HomeTeam": "/sport_teams/1",
                     "AwayTeam": "/sport_teams/2",
                     "Id": 1,
                     "location": "Trocardière",
                     "startDate": "2018-12-01T00:00:00+01:00"
                 }
             ],
             "hydra:totalItems": 1,
             "hydra:view": {
                 "@id": "/sport_events?orderStartDate=asc",
                 "@type": "hydra:PartialCollectionView"
             },
             "hydra:search": {
                 "@type": "hydra:IriTemplate",
                 "hydra:template": "/sport_events{?order[StartDate],StartDate[before],StartDate[strictly_before],StartDate[after],StartDate[strictly_after]}",
                 "hydra:variableRepresentation": "BasicRepresentation",
                 "hydra:mapping": [
                     {
                         "@type": "IriTemplateMapping",
                         "variable": "order[StartDate]",
                         "property": "StartDate",
                         "required": false
                     },
                     {
                         "@type": "IriTemplateMapping",
                         "variable": "StartDate[before]",
                         "property": "StartDate",
                         "required": false
                     },
                     {
                         "@type": "IriTemplateMapping",
                         "variable": "StartDate[strictly_before]",
                         "property": "StartDate",
                         "required": false
                     },
                     {
                         "@type": "IriTemplateMapping",
                         "variable": "StartDate[after]",
                         "property": "StartDate",
                         "required": false
                     },
                     {
                         "@type": "IriTemplateMapping",
                         "variable": "StartDate[strictly_after]",
                         "property": "StartDate",
                         "required": false
                     }
                 ]
             }
         }
   """



 # The "@dropSchema" annotation must be added on the last scenario of the feature file to drop the temporary SQLite database
 @dropSchema
 @login
   Scenario: Delete a Game
     When I add "Content-Type" header equal to "application/ld+json"
     When I add "Accept" header equal to "application/ld+json"
     And I send a "DELETE" request to "/sport_events/1"
     Then the response status code should be 204
