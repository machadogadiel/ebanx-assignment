## EBANX Software Engineer Take-home assignment.

Here are some initial decisions I made before starting the project, and my rationale behind those decisions:

- PHP was choosen as the language of implementation.

*Why?:* I'm not really familiar with PHP, in fact, I never programmed a line of PHP, but as an ex-Alumni of Códigos do Amanhã I remember a talk from João Del Valle about how he implemented everything initially and the surprising throughput using PHP, so quite likely I will be working with PHP and took on the challenge of learning it while implementing this assignment.

- Slim was choosen web framework.

*Why?:* I wanted something very very simple as it's expected in this challenge, so I asked Gemini what was the simplest framework to implement MVC architecture in PHP, and among the options I ended up choosing Slim for it's popularity, simplicity and maturity. (Other options were Flight, and FrameworkX)

- JSON is used to store data

*Why?:* I tried storing data in-memory, but failed because Slim requests are stateless, so data is wiped from memory after every request (being stateless is a good thing btw, just explaning why JSON)

## Folder Structure
- `api/`: Contains source code files for the api.
- `controllers/`: Contains the controller logic for handling HTTP requests.
- `db/`: Contains the Data Store which is handles file manipulation in JSON and serves as database.
- `db/data/accounts.json`: JSON file used to store the API data.
- `models/`: Contains the models.
- `routes/`: Contains the route definitions for the API endpoints.
- `vendor/`: Contains the dependencies installed via Composer.
- `composer.json`: Composer configuration file.
- `index.php`: Entry point of the application.

## How to get started

You will need to have PHP (latest) and composer installed.

- Clone the project
- Install the dependencies: `composer install`;
- Start the server in your preferred port (default: 8888): `php -S localhost:8888`.

## Note to EBANX's hiring team

Thanks a lot for taking the time to review my profile and code, and inviting me to do this assignment, while it was very challenging learning PHP and implementing this, it was fun! :)
