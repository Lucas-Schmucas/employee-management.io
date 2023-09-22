# Job application test task v2

LBX test task
=============

Global requirements
-------------------



*   use a php framework / toolstack you are familiar with
*   php: object oriented programming, php v8.0+ if possible
*   use mysql/mariadb database
*   bundle a `README.MD` containing instructions on how to run and use your app

* * *

In general
----------



You can scratch conceptional stuff that you would normally implement for the given task (security code + domain structures, performance optimizations) in your own `readme.md` or in code comments



Focus on code structure / readability / robustness / scalability

* * *



Create an employee batch import + management REST API
-----------------------------------------------------



### Create the entity:

Employees should be represented by a data model with proper data types containing these fields taken from the `import.csv` :

[import.csv](https://t36654621.p.clickup-attachments.com/t36654621/cc240282-787a-4c10-9ee5-93e9f65f4128/import.csv)



*   Employee ID (unique Identifier)
*   User Name
*   Name Prefix
*   First Name
*   Middle Initial
*   Last Name
*   Gender
*   E-Mail
*   Date of Birth
*   Time of Birth
*   Age in Yrs.
*   Date of Joining
*   Age in Company (Years)
*   Phone No.
*   Place Name
*   County
*   City
*   Zip
*   Region



### Batch processing API:



Create an endpoint `POST /api/employee` accepting CSV files. Keep in mind those files can be huge and must work reliably. The `import.csv` provided must be processible with your api.



[import.csv](https://t36654621.p.clickup-attachments.com/t36654621/cc240282-787a-4c10-9ee5-93e9f65f4128/import.csv)



This endpoint should be able to handle the following example request with the csv file provided.



`curl -X POST -H 'Content-Type: text/csv' -d @import.csv http://{yourapp}/api/employee`

### REST API's



Realize classic RESTful API's for employee management:

*   `GET /api/employee`
*   `GET /api/employee/{id}`
*   `DELETE /api/employee/{id}`



Output should be `JSON`

---

### Thoughts

We know that you don't want to spent ages on this task. But please tell us what you would have done different/additionally if this would have been a real work task scenario. We're really curious about your thoughts

---


Submitting your results
-----------------------



Please package your results and omit composer/3rd party deps to reduce file

size. You don't need to submit test data files, we'll use the import.csv provided.



[questionnaire.xlsx](https://t36654621.p.clickup-attachments.com/t36654621/7c777b52-ddc4-4a14-b7b2-9dd357b99603/questionnaire.xlsx)



!! Please make sure to include instructions on how to setup your app, the database etc. !!


