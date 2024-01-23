<?php

namespace LZKs\Token;

use LZKs\PopBaseJsonEntity;

/**
 * AccessToken request类
 */
class AccessTokenRequest extends PopBaseJsonEntity
{

    /**
     * @JsonProperty(String, "app_id")
     */
    private $appId;

    /**
     * @JsonProperty(String, "app_secret")
     */
    private $appSecret;

    /**
     * @JsonProperty(String, "grant_type")
     */
    private $grantType;

    /**
     * @JsonProperty(String, "code")
     */
    private $code;

    public function __construct()
    {

    }

    public function getAppId()
    {
        return $this->appId;
    }

    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    public function getAppSecret()
    {
        return $this->appSecret;
    }

    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
    }

    public function getGrantType()
    {
        return $this->grantType;
    }

    public function setGrantType($grantType)
    {
        $this->grantType = $grantType;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }
}
