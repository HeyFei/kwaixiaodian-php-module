<?php

namespace LZKs;

/**
 * Pop request类
 */
abstract class PopBaseHttpRequest extends PopBaseJsonEntity
{
    private $timestamp;

    public function __construct()
    {
    }

    public function getTimestamp()
    {
        if ($this->timestamp == null) {
            list($msec, $sec) = explode(' ', microtime());

            $this->timestamp = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        }

        return $this->timestamp;
    }

    public abstract function getVersion();

    public final function getParamsMap()
    {
        $paramsMap = array();
        $paramsMap["version"] = $this->getVersion();
        $paramsMap["method"] = $this->getMethod();
        $paramsMap["timestamp"] = $this->getTimestamp();
        $paramsMap["signMethod"] = $this->getSignMethod();
        
        return $paramsMap;
    }


    protected abstract function setUserParams(&$var);

    protected final function setUserParam(&$paramMap, $name, $param)
    {
        if (!is_null($param) && $param !== "") {
            if ($this->isPrimaryType($param)) {
                $paramMap[$name] = $param;
            } else {
                $paramMap[$name] = json_encode($param);
            }
        }

    }

    private function isPrimaryType($param)
    {
        if (is_bool($param)) {
            return true;
        } else if (is_integer($param)) {
            return true;
        } else if (is_long($param)) {
            return true;
        } else if (is_float($param)) {
            return true;
        } else if (is_double($param)) {
            return true;
        } else if (is_numeric($param)) {
            return true;
        } else {
            return is_string($param);
        }
    }
}
