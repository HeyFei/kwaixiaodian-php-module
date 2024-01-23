<?php

namespace LZKs\Api\Request;

use LZKs\PopBaseHttpRequest;

class KsOrderRefundSearchRequest extends PopBaseHttpRequest
{
    public function __construct()
    {

    }

    /**
     * @JsonProperty(Long, "beginTime")
     */
    private $beginTime;

    /**
     * @JsonProperty(Long, "endTime")
     */
    private $endTime;

    /**
     * @JsonProperty(Integer, "type")
     */
    private $type;

    /**
     * @JsonProperty(Integer, "pageSize")
     */
    private $pageSize;

    /**
     * @JsonProperty(Integer, "currentPage")
     */
    private $currentPage;

    /**
     * @JsonProperty(Integer, "sort")
     */
    private $sort;

    /**
     * @JsonProperty(Integer, "queryType")
     */
    private $queryType;

    /**
     * @JsonProperty(Integer, "negotiateStatus")
     */
    private $negotiateStatus;

    /**
     * @JsonProperty(String, "pcursor")
     */
    private $pcursor;

    /**
     * @JsonProperty(Integer, "status")
     */
    private $status;

    protected function setUserParams(&$params)
    {
        $this->setUserParam($params, "beginTime", $this->beginTime);
        $this->setUserParam($params, "endTime", $this->endTime);
        $this->setUserParam($params, "type", $this->type);
        $this->setUserParam($params, "pageSize", $this->pageSize);
        $this->setUserParam($params, "currentPage", $this->currentPage);
        $this->setUserParam($params, "sort", $this->sort);
        $this->setUserParam($params, "queryType", $this->queryType);
        $this->setUserParam($params, "negotiateStatus", $this->negotiateStatus);
        $this->setUserParam($params, "pcursor", $this->pcursor);
        $this->setUserParam($params, "status", $this->status);
    }

    public function getVersion()
    {
        return 1;
    }

    public function getMethod()
    {
        return "open.seller.order.refund.pcursor.list";
    }

    public function getSignMethod()
    {
        return 'MD5';
    }

    public function setBeginTime($beginTime)
    {
        $this->beginTime = $beginTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setPage($page)
    {
        $this->currentPage = $page;
    }

    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function setQueryType($queryType)
    {
        $this->queryType = $queryType;
    }

    public function setNegotiateStatus($negotiateStatus)
    {
        $this->negotiateStatus = $negotiateStatus;
    }

    public function setPcursor($pcursor)
    {
        $this->pcursor = $pcursor;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}
