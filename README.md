[![Build Status](https://travis-ci.org/trideout/boojbooks.svg?branch=master)](https://travis-ci.org/trideout/boojbooks)
## Booj Books

API developed using TDD using Laravel
 
Postman Collection available in root folder as `BoojBooks.postman_collection.json`

Tests can be run by calling `./vendor/bin/phpunit` and is configured for my homestead development environment pointing at http://local.bookbooks.com

Front end is written in Vue.js with ajax support using the Axios library. Style provided by TailwindsCss. Drag and drop sorting functionality is using the vue-draggable component.

Live code is deployed to a Digital Ocean Droplet running PHP 7.2, Nginx, Mysql and is hosted on my personal domain at http://booj.controlleranatomy.com

### Possible Improvements
User based lists

Travis CI integration

Custom deployment with Forge or Envoyer

Amazon API integration to look up details and auto-fill missing content.
 
