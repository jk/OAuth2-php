<?php
namespace JK\OAuth2\MongoDB;

/**
 * MongoDB storage engine for the OAuth2 Library.
 *
 * Usage example:
 * <code>
 * $dsn = 'mongodb://user:passwd@hostname:post/database';
 * $options = array('replSet' => 'foo');
 * $storage = new OAuth2StorageMongo($dsn, $options);
 * $oauth = new OAuth2($storage);
 * </code>
 */
class OAuth2StorageMongo implements IOAuth2GrantCode, IOAuth2RefreshTokens {

  /**
   * Change this to something unique for your system
   * @var string
   */
  const SALT = 'CHANGE_ME!';

   /**@#+
   * Centralized collection names
   * 
   * @var string
   */
  const COLLECTION_CLIENTS = 'clients';
  const COLLECTION_CODES   = 'auth_codes';
  const COLLECTION_TOKENS  = 'access_tokens';
  const COLLECTION_REFRESH = 'refresh_tokens';
  /**@#-*/
  
  /**
   * @var MongoDB
   */
  private $db;

  /**
   * Implements OAuth2::__construct().
   */
  public function __construct($dsn, $options = null) {
    try {
      $mongo = new Mongo($dsn, $options);
      preg_match('/\/(\w*)$/', $dsn, $matches);
      $db = $matches[1];
      $this->db = $mongo->selectDB($db);
    }
    catch (Exception $e) {
      $this->handleException($e);
    }
  }

  /**
   * Handle PDO exceptional cases.
   */
  private function handleException($e) {
    echo 'MongoDB error: '. $e->getMessage();
    exit;
  }

  /**
   * Little helper function to add a new client to the database.
   *
   * @param $client_id
   *   Client identifier to be stored.
   * @param $client_secret
   *   Client secret to be stored.
   * @param $redirect_uri
   *   Redirect URI to be stored.
   */
  public function addClient($client_id, $client_secret, $redirect_uri) {
    try {
      $collection = $this->db->selectCollection(self::COLLECTION_CLIENTS);
      $collection->insert(array(
        '_id' => $client_id,
        'client_secret' => $this->hash($client_secret, $client_id),
        'redirect_uri' => $redirect_uri
      ));
    } catch(Exception $e) {
      $this->handleException($e);
    }
  }

  /**
   * Implements IOAuth2Storage::checkClientCredentials().
   *
   */
  public function checkClientCredentials($client_id, $client_secret = NULL) {
    $collection = $this->db->selectCollection(self::COLLECTION_CLIENTS);
    $result = $collection->findOne(array('_id' => $client_id));
    return $this->checkclient_secret($result['client_secret'], $client_secret, $client_id);
  }

  /**
   * Implements IOAuth2Storage::getRedirectUri().
   */
  public function getClientDetails($client_id) {
    $collection = $this->db->selectCollection(self::COLLECTION_CLIENTS);
    $result = $collection->findOne(array('_id' => $client_id));
    return isset($result['redirect_uri']) && $result['redirect_uri'] ? $result : false;
  }

  /**
   * Implements IOAuth2Storage::getAccessToken().
   */
  public function getAccessToken($oauth_token) {
    return $this->getToken($oauth_token, FALSE);
  }

  /**
   * Implements IOAuth2Storage::setAccessToken().
   */
  public function setAccessToken($oauth_token, $client_id, $user_id, $expires, $scope = NULL) {
    $this->setToken($oauth_token, $client_id, $user_id, $expires, $scope, FALSE);
  }
  
  /**
   * @see IOAuth2Storage::getRefreshToken()
   */
  public function getRefreshToken($refresh_token) {
    return $this->getToken($refresh_token, TRUE);
  }
  
  /**
   * @see IOAuth2Storage::setRefreshToken()
   */
  public function setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope = NULL) {
    return $this->setToken($refresh_token, $client_id, $user_id, $expires, $scope, TRUE);
  }
  
  /**
   * @see IOAuth2Storage::unsetRefreshToken()
   */
  public function unsetRefreshToken($refresh_token) {
    $collection = $this->db->selectCollection(self::COLLECTION_TOKENS);
    $collection->remove(array('refresh_token' => $refresh_token));
  }

  /**
   * Implements IOAuth2Storage::getAuthCode().
   */
  public function getAuthCode($code) {
    $collection = $this->db->selectCollection(self::COLLECTION_CODES);
    $stored_code = $collection->findOne(array('_id' => $code));
    return $stored_code !== NULL ? $stored_code : FALSE;
  }

  /**
   * Implements IOAuth2Storage::setAuthCode().
   */
  public function setAuthCode($code, $client_id, $user_id, $redirect_uri, $expires, $scope = NULL) {
    $collection = $this->db->selectCollection(self::COLLECTION_CODES);
    $collection->insert(array(
      '_id' => $code,
      'client_id' => $client_id,
      'user_id' => $user_id,
      'redirect_uri' => $redirect_uri,
      'expires' => $expires,
      'scope' => $scope
    ));
  }
  
  /**
   * @see IOAuth2Storage::checkRestrictedGrantType()
   */
  public function checkRestrictedGrantType($client_id, $grant_type) {
    return TRUE; // Not implemented
  }
  
 /**
   * Creates a refresh or access token
   * 
   * @param string $token - Access or refresh token id
   * @param string $client_id
   * @param mixed $user_id
   * @param int $expires
   * @param string $scope
   * @param bool $isRefresh
   */
  protected function setToken($token, $client_id, $user_id, $expires, $scope, $isRefresh = TRUE) {
    try {
      $collectionName = $isRefresh ? self::COLLECTION_REFRESH :  self::COLLECTION_TOKENS;
      $collection = $this->db->selectCollection($collectionName);
      $collection->insert(array(
        '_id' => $token,
        'client_id' => $client_id,
        'user_id' => $user_id,
        'expires' => $expires,
        'scope' => $scope
      ));
    } catch (Exception $e) {
      $this->handleException($e);
    }
  }
  
  /**
   * Retreives user data for an access or refresh token.
   *  
   * @param string $token Token 
   * @param bool $isRefresh Retrieving an access or a refresh token?
   * @return string Access or refresh token
   */
  protected function getToken($token, $isRefresh = true) {
    $tokenName = $isRefresh ? 'refresh_token' : 'oauth_token';

    try {
      $collectionName = $isRefresh ? self::COLLECTION_REFRESH :  self::COLLECTION_TOKENS;
      $collection = $this->db->selectCollection($collectionName);
      $result = $collection->findOne(array(
        '_id' => $token
        ));

      $result[$tokenName] = $result['_id'];
      unset($result['_id']);
      return $result !== NULL ? $result : false;
    } catch (Exception $e) {
      $this->handleException($e);
    }
  }

  /**
   * Change/override this to whatever your own client_secret hashing method is.
   *
   * Make sure that you don't use 'sha' as a hashing algorithm ('sha256' is fine)
   * 
   * @param string $client_secret Unencrypted client secret
   * @param string $client_id Client id
   * @return string Hashed version of Client id and secret
   */
  protected function hash($client_secret, $client_id) {
  	return hash('sha256', $client_id.$client_secret.self::SALT);
  }
  
  /**
   * Checks the client_secret.
   * Override this if you need to
   * 
   * @param string $try The received hash of the client
   * @param string $client_secret The actual unencrypted secret from the storage
   * @param string $client_id The client id, also from storage
   * @param bool Valid or invalid result of the comparsion of the hashes
   */
  protected function checkclient_secret($try, $client_secret, $client_id) {
  	return $try == $this->hash($client_secret, $client_id);
  }
}