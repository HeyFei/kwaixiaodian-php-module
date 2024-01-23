<?php

namespace LZKs\Api\Request;

use LZKs\PopBaseHttpRequest;
use LZKs\PopBaseJsonEntity;

class KsOrderSearchRequest extends PopBaseHttpRequest
{
    public function __construct()
    {

    }

    /**
     * @JsonProperty(Long, "endTime")
     */
    private $endTime;

    /**
     * @JsonProperty(Long, "beginTime")
     */
    private $beginTime;

    /**
     * @JsonProperty(Long, "sort")
     */
    private $sort;

    /**
     * @JsonProperty(String, "cursor")
     */
    private $cursor;

    /**
     * @JsonProperty(Integer, "orderViewStatus")
     */
    private $orderViewStatus;

    /**
     * @JsonProperty(Integer, "pageSize")
     */
    private $pageSize;

    /**
     * @JsonProperty(Integer, "queryType")
     */
    private $queryType;

    /**
     * @JsonProperty(Integer, "cpsType")
     */
    private $cpsType;

    protected function setUserParams(&$params)
    {
        $this->setUserParam($params, "endTime", $this->endTime);
        $this->setUserParam($params, "beginTime", $this->beginTime);
        $this->setUserParam($params, "sort", $this->sort);
        $this->setUserParam($params, "cursor", $this->cursor);
        $this->setUserParam($params, "orderViewStatus", $this->orderViewStatus);
        $this->setUserParam($params, "pageSize", $this->pageSize);
        $this->setUserParam($params, "queryType", $this->queryType);
        $this->setUserParam($params, "cpsType", $this->cpsType);

    }

    public function getVersion()
    {
        return 1;
    }

    public function getMethod()
    {
        return "open.order.cursor.list";
    }

    public function getSignMethod()
    {
        return 'MD5';
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function setBeginTime($beginTime)
    {
        $this->beginTime = $beginTime;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function setCursor($cursor)
    {
        $this->cursor = $cursor;
    }

    public function setOrderViewStatus($orderViewStatus)
    {
        $this->orderViewStatus = $orderViewStatus;
    }

    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
    }

    public function setQueryType($queryType)
    {
        $this->queryType = $queryType;
    }

    public function setCpsType($cpsType)
    {
        $this->cpsType = $cpsType;
    }
}
