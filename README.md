# Task description

## Back end

Create a database that stores panelist personal information (firstname, lastname,
email, phone, country and agreement to receive newsletters, created date).
Database also keeps records of available surveys (name, status (tells if it's 
active/inactive), created date. CRUD functionality needs to be created following
common practices in Symfony - controllers, forms, validation, etc. Delete
functionality needs to use soft delete logic.

## Front end

Provide basic CRUD functionality that allows to manage lists of panelists and
surveys. Under panelist details preview page their is a need to have ability to
assign surveys to panelists. Design can be as simple as possible, but usable and
tidy. No need to have icons or backgrounds and etc.

## Technical requirements:

* Symfony (LTS version)
* Twig
* ORM
* Maria DB
* PHP 8.x
* Docker

# Installation

1. Run:
   ```shell
   docker compose up --build --detach
   docker compose exec -it php make install
   ```
2. Open http://localhost:8080
