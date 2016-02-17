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


### How to use Pact-Php-Client
Examples can be found at [usages catalog](http://dius.com.au/2016/02/03/microservices-pact). For more information check above links.  
If you don't want to host your own `pact-mock-service`, you can use our docker image (You need to have `docker-compose`).  
To do so from the root catalog type in console `docker-compose up -d` and start examples `php usage/single-interaction.php`.

### License
The MIT License (MIT)

Copyright (c) 2016 Madkom S.A.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.