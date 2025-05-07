Here are some initial decisions I made before starting the project, and my rationale behind those decisions:

- PHP was choosen as the language of implementation
Rationale: I'm not really familiar with PHP, in fact, I never programmed a line of PHP, but as an ex-Alumni of Códigos do Amanhã I remember a talk from João Del Valle about how he implemented everything initially and the surprising throughput using PHP, so quite likely I will be working with PHP and took on the challenge of learning it while implementing this assignment.

- Slim was choosen web framework
Rationale: I wanted something very very simple as it's expected in this challenge, so I asked Gemini what was the simplest framework to implement MVC architecture, and among the options and choose Slim for it's popularity, simplicity and maturity. (Other options were Flight, and FrameworkX)

- As per the spec, I don't intend in implementing persistence mechanisms, rather I will be using a global state Class, to keep things simple.
Rationale: My strategy is to make a simple class, with basic methods, that can be easily adapter later on if I'm asked to implement a database.
