# Setup

# Components

- MariaDB
- Laravel 10
-

# Thoughts

- I start with a test for the post route, to check for correct response and database saving. Therefore, I use the given
  csv and curl request. I don't use factories, to save time. "DatabaseTransactions" should also do the trick.
- I separated the Models for Employee and Address, this will pay of as the application grows. I could do more separation
  in models (country, prefix, gender), but only addresses is fine for now

# TODOs
- Routes
  - POST /api/employee + Test
  - GET /api/employee + Test
  - GET /api/employee/{id} + Test
  - DELETE /api/employee/{id} + Test
- Controller
- Models
- Serialize missing csv attributes in model (age)
- Packaging
- Documentation


# Done

- Migrations


# Improvements for later

- Factories
- Foreign Key Constraints (cascade, restrict)
- The "GET /api/employee" Route should have pagination

