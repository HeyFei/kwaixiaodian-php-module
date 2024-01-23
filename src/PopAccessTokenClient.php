<?php

namespace LZKs;

use LZKs\Token\AccessTokenRequest;
use LZKs\Token\RefreshAccessTokenRequest;

/**
 * Pop接口调用的客户端类
 */
class PopAccessTokenClient
{
    /**
     * SDK版本号
     */
    public static $VERSION = "0.0.1";

    /**
     * 接口超时时间
     */
    private static $SECONDS = "30";

    private $clientSecret;
    private $clientId;

    /**
     * 构造函数
     * @param $clientId 开放平台分配的clientId
     * @param $clientSecret 开放平台分配的clientSecret
     */
    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param $code 授权获取到的code
     * @param $url 请求地址
     * @return  返回AccessTokenResponse对象
     */
    public function generate($code, $url)
    {
        if (empty($code)) {
            throw new PopHttpException("Code不能为空");
        }

        $request = new AccessTokenRequest();
        $request->setAppId($this->clientId);
        $request->setAppSecret($this->clientSecret);
        $request->setCode($code);
        $request->setGrantType("code");

        $params = json_decode(json_encode($request), true);
        $url = $url . '?' . http_build_query($params);

        $response = $this->getCurl($url);

        return $response;
    }

    /**
     * @param $refreshToken generate接口获取到的refresh_token，refresh_token有效期默认180天
     * @return 返回刷新后的access_token
     */
    public function refresh($refreshToken, $url)
    {
        if (empty($refreshToken)) {
            throw new PopHttpException("Refresh token 不能为空");
        }

        $request = new RefreshAccessTokenRequest();
        $request->setAppId($this->clientId);
        $request->setAppSecret($this->clientSecret);
        $request->setRefreshToken($refreshToken);
        $request->setGrantType("refresh_token");

        $params = json_decode(json_encode($request), true);
        $url = $url . '?' . http_build_query($params);

        $response = $this->getCurl($url);

        return $response;
    }

    private function getCurl($url)
    {
        $ch = curl_init();
        $curlVersion = curl_version();

        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$SECONDS);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);//严格校验

        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //运行curl
        $raw_response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //返回结果
        if ($raw_response) {
            curl_close($ch);

            $response = new PopHttpResponse();
            $response->setStatusCode($status_code);
            $response->setBody($raw_response);

            return $response;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new PopHttpException("curl出错，错误码:$error");
        }
    }

}
