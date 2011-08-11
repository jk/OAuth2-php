![OAuth 2 logo](Icon.png "OAuth 2 logo")
# OAuth2 PHP implementation
This implementation consists of a server and client.

The `master` branch implements the [IETF OAuth 2.0 Draft 10](http://tools.ietf.org/html/draft-ietf-oauth-v2-10) specification. You should proabably take a look at the `draft-20` branch for the latest and greatest code. [Draft 20](http://tools.ietf.org/html/draft-ietf-oauth-v2-20) was marked to be ready to implement and should be the last draft of OAuth 2.0 before it goes RFC. The `draft-20` branch aims to implement the [Bearer Token Draft](http://tools.ietf.org/html/draft-ietf-oauth-v2-bearer) and perhaps in the future even the [MAC Token Draft](http://tools.ietf.org/html/draft-hammer-oauth-v2-mac-token).

## Requirments
* A recent version of PHP5 (tested on PHP 5.3.5)
* PDO supported SQL backend (tested with MySQL 5.5.9), if you want to use the PDO example
 * but you can implement the IOAuth2* interfaces under the `lib` directory by your self (there is no reason, why a NoSQL backend shouldn't be working)

## How to setup the OAuth 2 server component
Please have look in  `server/examples/pdo` directory. This should be working with a MySQL server. You can find the scheme SQL under `server/examples/pdo/mysql_create_tables.sql` and adjust the PDO dsn in `server/examples/pdo/config.php`.

## References
* [Official OAuth 2.0 website](http://oauth.net/2/)
* [Latest IETF OAuth 2 Draft](http://tools.ietf.org/html/draft-ietf-oauth-v2) ([Draft 20](http://tools.ietf.org/html/draft-ietf-oauth-v2-20), [Draft 10](http://tools.ietf.org/html/draft-ietf-oauth-v2-10))
* [Latest IETF OAuth 2 Bearer Token Draft](http://tools.ietf.org/html/draft-ietf-oauth-v2-bearer)
* [Latest IETF OAuth 2 MAC Token Draft](http://tools.ietf.org/html/draft-hammer-oauth-v2-mac-token)

## Licensing
This repository is released under the MIT licence. Check `LICENSE.txt` for more detail.