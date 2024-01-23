<?php

namespace LZKs;

/**
 * Pop接口调用的客户端类
 */
class PopHttpClient
{
    /**
     * SDK版本号
     */
    public static $VERSION = "0.0.1";

    /**
     * 接口超时时间
     */
    private static $SECONDS = "30";

    /**
     * @var string API协议版本号，默认V1
     */
    private $API_VERSION = 1;

    private $clientId;

    private $clientSecret;

    private $signSecret;

    private $apiServerUrl = "https://openapi.kwaixiaodian.com/";

    /**
     * 构造函数
     * @param string $clientId 开放平台分配的clientId
     * @param string $clientSecret 开放平台分配的clientSecret
     */
    public function __construct($clientId, $clientSecret, $signSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->signSecret = $signSecret;
    }

    /**
     * 接口调用函数
     * @param $request 是 Array 类型，里面包含API接口名称method（必填）
     * @param $access_token 表示调用接口的授权码
     * @return 接口返回信息
     */
    public function syncInvoke($request, $access_token = '')
    {
        $paramJson = $this->paramsHandle($request);

        $params = $this->uniqueParams($request, $access_token);

        $params['param'] = $paramJson == '[]' ? '{}' : $paramJson;;

        $sign = $this->signature($params);

        $params['sign'] = $sign;

        $response = $this->postCurl($params);

        return $response;
    }

    private function paramsHandle($request)
    {
        $params = json_decode(json_encode($request), true);

        ksort($params);

        return json_encode($params, 320);
    }

    /**
     * 构造全部参数
     * @param $request请求参数 $access_token 授权参数
     * @return 构造后的所有参数
     */
    private function uniqueParams($request, $access_token)
    {
        $params = $request->getParamsMap();

        $params['appkey'] = $this->clientId;

        if ($access_token) {
            $params['access_token'] = $access_token;
        }

        //把boolean转为true 和 false
        foreach ($params as $key => $val) {
            if (is_bool($val)) {
                $params[$key] = $val ? "true" : "false";
            }
        }

        return $params;
    }

    private function signature(array $params)
    {
        ksort($params);
        $paramsStr = '';
        array_walk($params, function ($item, $key) use (&$paramsStr) {
            if ('@' != substr($item, 0, 1)) {
                $paramsStr .= sprintf('%s%s%s%s', $key, '=', $item, '&');
            }
        });

        return md5(sprintf('%s%s%s%s', $paramsStr, 'signSecret', '=', $this->signSecret));
    }

    private function getUri(string $method)
    {
        return str_replace('.', '/', $method);
    }

    private function postCurl($params)
    {
        $ch = curl_init();
        $curlVersion = curl_version();
        $ua = "PopSDK/" . self::$VERSION . " (" . PHP_OS . ") PHP/" . PHP_VERSION . " CURL/" . $curlVersion['version'] . " "
            . $this->clientId;

        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$SECONDS);

        curl_setopt($ch, CURLOPT_URL, $this->apiServerUrl . $this->getUri($params['method']));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);//严格校验
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, false);

        //设置header
        $headers = array(
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Pdd-Sdk-Version: " . self::$VERSION,
            "Pdd-Sdk-Type: PHP"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

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
