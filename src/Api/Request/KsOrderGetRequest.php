<?php

namespace LZKs\Api\Request;

use LZKs\PopBaseHttpRequest;

class KsOrderGetRequest extends PopBaseHttpRequest
{
    public function __construct()
    {

    }

    /**
     * @JsonProperty(String, "oid")
     */
    private $oid;

    protected function setUserParams(&$params)
    {
        $this->setUserParam($params, "oid", $this->oid);

    }

    public function getVersion()
    {
        return 1;
    }

    public function getMethod()
    {
        return "open.order.detail";
    }

    public function getSignMethod()
    {
        return 'MD5';
    }

    public function setOrderId($oid)
    {
        $this->oid = $oid;
    }
}
