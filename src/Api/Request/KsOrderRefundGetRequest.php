<?php

namespace LZKs\Api\Request;

use LZKs\PopBaseHttpRequest;

class KsOrderRefundGetRequest extends PopBaseHttpRequest
{
    public function __construct()
    {

    }

    /**
     * @JsonProperty(Long, "refundId")
     */
    private $refundId;

    protected function setUserParams(&$params)
    {
        $this->setUserParam($params, "refundId", $this->refundId);

    }

    public function getVersion()
    {
        return 1;
    }

    public function getMethod()
    {
        return "open.seller.order.refund.detail";
    }

    public function getSignMethod()
    {
        return 'MD5';
    }

    public function setRefundId($refundId)
    {
        $this->refundId = $refundId;
    }
}
