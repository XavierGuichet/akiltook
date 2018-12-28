# features/books.feature
Feature: Manage matches
  In order to manage matches
  As a user
  I need to be able to retrieve, create, update and delete them through the API.

  # the "@createSchema" annotation provided by API Platform creates a temporary SQLite database for testing the API
 @createSchema
 Scenario: Create a match
   When I add "Content-Type" header equal to "application/ld+json"
   And I add "Accept" header equal to "application/ld+json"
   And I send a "POST" request to "/matches" with body:
   """
   {
     "location": "Trocardière",
     "atHome": "true",
     "Team1": "Feminine A",
     "Team2": "FC Nantes",
     "startAt": "2018-12-01T00:00:00+00:00"
   }
   """
   Then the response status code should be 201
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
     "@context": "/contexts/Match",
     "@id": "/matches/1",
     "@type": "Book",
     "id": 1,
     "location": "Trocardière",
     "atHome": "true",
     "Team1": "Feminine A",
     "Team2": "FC Nantes",
     "startAt": "2018-12-01T00:00:00+00:00"
   }
   """

 Scenario: Retrieve the matches list
   When I add "Accept" header equal to "application/ld+json"
   And I send a "GET" request to "/matches"
   Then the response status code should be 200
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
     "@context": "/contexts/Match",
     "@id": "/matches",
     "@type": "hydra:Collection",
     "hydra:member": [
       {
         "@id": "/matches/1",
         "@type": "Match",
         "id": 1,
         "location": "Trocardière",
         "atHome": "true",
         "Team1": "Feminine A",
         "Team2": "FC Nantes",
         "startAt": "2018-12-01T00:00:00+00:00"
       }
     ],
     "hydra:totalItems": 1
   }
   """

 Scenario: Throw errors when a post is invalid
   When I add "Content-Type" header equal to "application/ld+json"
   And I add "Accept" header equal to "application/ld+json"
   And I send a "POST" request to "/matches" with body:
   """
   {
     "Team1": "",
     "Team2": "",
     "startAt": ""
   }
   """
   Then the response status code should be 400
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
     "@context": "/contexts/ConstraintViolationList",
     "@type": "ConstraintViolationList",
     "hydra:title": "An error occurred",
     "hydra:description": "Team1: This value should be an existing team.\nTeam2: This value should not be blank.\nstartAt: This value should not be blank.",
     "violations": [
       {
         "propertyPath": "Team1",
         "message": "This value should be an existing team."
       },
       {
         "propertyPath": "Team2",
         "message": "This value should not be blank."
       },
       {
         "propertyPath": "startAt",
         "message": "This value should not be blank."
       }
     ]
   }
   """

 # The "@dropSchema" annotation must be added on the last scenario of the feature file to drop the temporary SQLite database
 @dropSchema
   Scenario: Delete a Match
   When I add "Content-Type" header equal to "application/ld+json"
   When I add "Accept" header equal to "application/ld+json"
   And I send a "DELETE" request to "/matches/1"
   Then the response status code should be 201
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
     "@context": "/contexts/Review",
     "@id": "/reviews/1",
     "@type": "Review",
     "id": 1,
     "rating": 5,
     "body": "Must have!",
     "author": "Foo Bar",
     "publicationDate": "2016-01-01T00:00:00+00:00",
     "book": "/books/1"
   }
   """