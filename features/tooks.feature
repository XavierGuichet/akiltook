# features/books.feature
Feature: Manage tooks
  In order to manage tooks
  As a user
  I need to be able to retrieve a took, create a took, update my took and delete my took through the API.

  # the "@createSchema" annotation provided by API Platform creates a temporary SQLite database for testing the API
 @createSchema
 @login
 Scenario: Create a Took
   # Given I am connected
   Given There is a game with id "1"
   When I add "Content-Type" header equal to "application/ld+json"
   And I add "Accept" header equal to "application/ld+json"
   And I send a "POST" request to "/tooks" with body:
   """
   {
     "Event": "/games/1",
     "Title": "took",
     "Description": "Ce sera une took sans alcool"
   }
   """
   Then the response status code should be 201
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
     "@context": "/contexts/Took",
     "@id": "/tooks/1",
     "@type": "Took",
     "id": 1,
     "Event": "/games/1",
     "Title": "took",
     "Description": "Ce sera une took sans alcool",
     "CreatedBy": "/accounts/1",
     "DoneBy": null
   }
   """
   
 @login
 Scenario: Retrieve the tooks list
   When I add "Accept" header equal to "application/ld+json"
   And I send a "GET" request to "/tooks"
   Then the response status code should be 200
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
     "@context": "/contexts/Took",
     "@id": "/tooks",
     "@type": "hydra:Collection",
     "hydra:member": [
       {
         "@id": "/tooks/1",
         "@type": "Took",
         "id": 1,
         "Event": "/games/1",
         "Title": "took",
         "Description": "Ce sera une took sans alcool",
         "CreatedBy": "/accounts/1",
         "DoneBy": null
       }
     ],
     "hydra:totalItems": 1
   }
   """
   
 @login
 Scenario: Throw errors when a post is invalid
   Given It is pending
   When I add "Content-Type" header equal to "application/ld+json"
   And I add "Accept" header equal to "application/ld+json"
   And I send a "POST" request to "/tooks" with body:
   """
   {
     "Title": "",
     "Description": ""
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
     "hydra:description": "Event: This value should not be blank.\nTitle: This value should not be blank",
     "violations": [
       {
         "propertyPath": "Event",
         "message": "This value should be an existing event."
       },
       {
         "propertyPath": "Title",
         "message": "This value should not be blank."
       }
     ]
   }
   """
   
 @login
 Scenario: Modify a Took
   When I add "Content-Type" header equal to "application/ld+json"
   And I add "Accept" header equal to "application/ld+json"
   And I send a "PUT" request to "/tooks/1" with body:
   """
   {
     "Id": 1,
     "Description": "Je fais une took sans jus de banane"
   }
   """
   Then the response status code should be 200
   And the response should be in JSON
   And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
   And the JSON should be equal to:
   """
   {
     "@context": "/contexts/Took",
     "@id": "/tooks/1",
     "@type": "Took",
     "id": 1,
     "Event": "/games/1",
     "Title": "took",
     "Description": "Je fais une took sans jus de banane",
     "CreatedBy": "/accounts/1",
     "DoneBy": null
   }
   """
   
 # The "@dropSchema" annotation must be added on the last scenario of the feature file to drop the temporary SQLite database
 @dropSchema
 @login
 Scenario: Delete a Took
   When I add "Content-Type" header equal to "application/ld+json"
   When I add "Accept" header equal to "application/ld+json"
   And I send a "DELETE" request to "/tooks/1"
   Then the response status code should be 204