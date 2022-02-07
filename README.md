# PHP WebDriver tests sample project.
You need to run composer install command to build this project.
In this project, the written tests are presented as separate test-files and as a single file with a single Setup.
Configuration can be changed in consts file:
- You can switch browser instance in BROWSER global variable by specify browser name
- Selenium/Selenoid URL can be changed in LINK_SELENIUM global variable, set on localhost by default
# Execution
- run "vendor/phpunit/phpunit/phpunit -c phpunit.xml" for test execution via phpunit
- run "vendor/brianium/paratest/bin/paratest -c phpunit.xml.dist -p 3" for parallel test execution via paratest
