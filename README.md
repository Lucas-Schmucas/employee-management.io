# Setup

- `git clone` this repo
- run `composer install`
- run `npm install`
- create your own `.env` file and adjust the database connection according to your system
- run `php artisan migrate --force`, this will also create a database

# Components

- MariaDB
- Laravel 10

# Thoughts

- I start with a test for the post route, to check for correct response and database saving. Therefore, I use the given
  csv and curl request. I don't use factories, to save time. "DatabaseTransactions" in the test should also do the
  trick.
- I separated the Models for Employee and Address, this will pay of as the application grows. I could do more separation
  in models (country, prefix, gender), but only addresses is fine for now.
- There are sometimes blanks in the csv file keys. I implemented them as part of the COLUMN_MAPPING. Not sure if it
  would be better to somehow sanitize it to add more error tolerance. Mixed feelings about that.
- So what would happen if there is something wrong with the data, trying to get in the database. I choose for now to
  save no data, if there is something wrong with one Record, for consistency. A better attempt would be to make an
  upsert
  with logging and user feedback for the bad rows in the csv.
- I am at a point where I doubt, that is really the best to separate employee and address. Because of the nature of the
  input, there has to be some kind of separation process, which will end in slower upload times. I think in the future
  it will still be better to have to models, because this is now just an api endpoint, but in a real application there
  would be some kind of managing and working with the data, where separate models would make it
  easier. Using the POST Route with lots of data also sounds like a "one per month/week/day"-task. So there will
  probably be no hard feelings if the upload takes 1 sec longer.
- It would be better to adjust the relationship to 1-n for employee-address. This enables employees to have like a work
  address, a private address and so on.
- I am still struggling to use the given curl request. It seems like the request does not send the body, or maybe
  laravel does not find the body part without a key. Maybe there is something wrong with my curl on windows. The test is
  working in that part. I tried postman as alternative to curl to get better feedback, but that does not work ether. I
  will fix this later.
- The employee date mutation for the input and output works fine but needs fine-tuning in the future, because at the
  moment, every employee retrieved from the dat the database has that wacky date format from the import.csv.
- My EmployeeController is already so Validation will be part of request classes, or maybe I'll make a
  RequestPreparation class in the future.
- I didn't make it to the big-file-testing but there will probably be some adjustment in the php.ini because of the
  upload file size.
- 2

# TODOs

- Missing tests for destroy and index method
- Validation
- Documentation (maybe Swagger?)
- Packaging

# Done

- Serialize missing csv attributes in model (age)
- Format input for database
- Migrations
- DELETE /api/employee/{id} (NOT TESTED)
- GET /api/employee (NOT TESTED)
- Routes
- POST /api/employee + Test
- GET /api/employee/{id} + Test
- Resources
- Collection
- Models
- Controller
- Foreign Key Constraints (delete on cascade)
- Pagination for index method

# Improvements for later

- Date mutation at collection level instead of model level
- Factories for better testing
- Authorization with maybe token
- Improve Header Serialization
- Batch processing for storing in the database
- Improve data storage with upsert, logging and row specific user feedback for bad entry data.

