# Changelog
## Version x.y (← tag based)
* Feature X
* Feature Y

# Old changelog (Subversion repository)
See the old [Google Project](http://code.google.com/p/oauth2-php) for further details.

## Revision 23 (2011-01-25)
* introduce Drupal style ``getVariable()`` and setVariable, replace legacy
  variable get/set functions.
* remove hardcode PHP display\_error and errror\_reporting, as this should
  be manually implement within 3rd party integration.
* make verbose error as configurable and default disable, as this should
  be manually enable within 3rd party integration.
* add lib/OAuth2Client.inc and lib/OAuth2Exception.inc for client-side
  implementation.

## Revision 21 (2010-12-18)
* cleanup tabs and trailing whitespace at the end.
* remove server/examples/mongo/lib/oauth.php and
  server/examples/pdo/lib/oauth.php, so only keep single copy as
  lib /oauth.php.
* [issue #5](http://code.google.com/p/oauth2-php/issues/detail?id=5): Wrong variable name in `get_access_token()` in pdo\_oauth.php.
* [issue #6](http://code.google.com/p/oauth2-php/issues/detail?id=6): mysql\_create\_tables.sql should allow scope to be `NULL`.
* [issue #7](http://code.google.com/p/oauth2-php/issues/detail?id=7): `authorize_client_response_type()` is never used.
* [issue #9](http://code.google.com/p/oauth2-php/issues/detail?id=9): Change "redirect\_uri" filtering from `FILTER_VALIDATE_URL` to
  `FILTER_SANITIZE_URL`.
* better coding syntax for `error()` and `callback\_error()`.
* better pdo\_oauth2.php variable naming with change to
  mysql\_create\_tables.sql.
* change `REGEX_CLIENT_ID` as 3-32 characters long, so will work with `md5()`
  result directly.
* debug linkage to oauth2.php during previous commit.
* debug redirect\_uri check for `AUTH_CODE_GRANT_TYPE`, clone from
  `get_authorize_params()`.
* update mysql\_create\_tables.sql with phpmyadmin export format.
* rename library files, prepare for adding client-side implementation.
* code cleanup with indent and spacing.
* code cleanup `true`/`false`/`null` with `TRUE`/`FALSE`/`NULL`.
* rename constants with `OAUTH2_` prefix, prevent 3rd party integration
  conflict.
* remove HTTP 400 response constant, as useless refer to [IETF draft v10](http://tools.ietf.org/html/draft-ietf-oauth-v2-10).
* merge `ERROR_INVALID_CLIENT_ID` and `ERROR_UNAUTHORIZED_CLIENT` as
  `OAUTH2_ERROR_INVALID_CLIENT`, as refer to that of [IETF draft v9](http://tools.ietf.org/html/draft-ietf-oauth-v2-09) to [v10](http://tools.ietf.org/html/draft-ietf-oauth-v2-10) changes.
* improve constants comment with doxygen syntax.
* update class function call naming.
* coding style clean up.
* update part of documents.
* change `expirseRefreshToken()` as `unsetRefreshToken()`.
* update token and auth code generation as `md5()` result, simpler for manual
  debug with web browser.
* update all documents.
* restructure @ingroup.
* rename `checkRestrictedClientResponseTypes()` as
  `checkRestrictedAuthResponseType()`.
* rename ``checkRestrictedClientGrantTypes()`` as ``checkRestrictedGrantType()``.
* rename `error()` as `errorJsonResponse()`.
* rename `errorCallback()` as `errorDoRedirectUriCallback()`.
* rename `send401Unauthorized()` as `errorWWWAuthenticateResponseHeader()`,
  update support with different HTTP status code.
* update `__construct()` with array input.
* update `finishClientAuthorization()` with array input.
* add get/set functions for $access\_token\_lifetime, $auth\_code\_lifetime and
  $refresh\_token\_lifetime.
* fix a lots of typos.
* document all sample server implementation.
* more documents.
* add config.doxy for doxygen default setup.
* add MIT LICENSE.txt.
* add CHANGELOG.txt.

## Revision 9 (2010-09-04)
* fixes for [issue #2](http://code.google.com/p/oauth2-php/issues/detail?id=2) and 
  [issue #4](http://code.google.com/p/oauth2-php/issues/detail?id=4), updates OAuth 
  lib in the example folders to the latest version in the `lib` folder.
* updates server library to revision 10 of the OAuth 2.0 spec.
* adds an option for more verbose error messages to be returned in the JSON
  response.
* adds method to be overridden for expiring used refresh tokens.
* fixes bug checking token expiration.
* makes some more methods protected instead of private so they can be
  overridden.
* fixes [issue #1](http://code.google.com/p/oauth2-php/issues/detail?id=1)

## Revision 7 (2010-06-29)
* fixed mongo connection constants.
* updated store\_refresh\_token to include expires time.
* changed example server directory structure
* corrected "false" return result on get\_stored\_auth\_code.
* implemented PDO example adapter.
* corrected an error in assertion grant type.
* updated for [IETF draft v9](http://tools.ietf.org/html/draft-ietf-oauth-v2-09).
* updated updated to support v9 lib.
* added mysql table creation script.

## Revision 0  (2010-06-27)
* initial commit.