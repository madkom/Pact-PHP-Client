# Pact-PHP-Client
[![Build Status](https://travis-ci.org/madkom/Pact-PHP-Client.svg?branch=master)](https://travis-ci.org/madkom/Pact-PHP-Client)
[![Coverage Status](https://coveralls.io/repos/github/madkom/Pact-PHP-Client/badge.svg?branch=master)](https://coveralls.io/github/madkom/Pact-PHP-Client?branch=master)
[![Latest Stable Version](https://poser.pugx.org/madkom/pact-php-client/v/stable)](https://packagist.org/packages/madkom/pact-php-client)
[![Total Downloads](https://poser.pugx.org/madkom/pact-php-client/downloads)](https://packagist.org/packages/madkom/pact-php-client)

### What is Pact
Pact is [consumer driven contract](http://martinfowler.com/articles/consumerDrivenContracts.html). Is a way to define contract between consumers and provider.  
It help to keep your provider's API compatible with your consumers.

### Pact-Php-Client
Is client for [pact-mock-service](https://github.com/bethesque/pact-mock_service). Which is just implementation of [Ruby Pact](https://github.com/realestate-com-au/pact).  
Your tests against provider can be run as part of your Continues Integration system.   
For more information about how does Pact works go here [pact wiki](https://github.com/realestate-com-au/pact/wiki) and here for [microservices overview](http://dius.com.au/2016/02/03/microservices-pact) 


### How to you Pact-Php-Client
Examples can be found at [usages catalog](http://dius.com.au/2016/02/03/microservices-pact). For more information check above links.  
If you don't want to host your own `pact-mock-service`, you can use our docker image (You need to have `docker-compose`).  
To do so from the root catalog type in console `docker-compose up -d` and start examples `php usage/single-interaction.php`.