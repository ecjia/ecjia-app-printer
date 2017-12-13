<?php

namespace Royalcms\Component\Printer;

use Exception;
use ecjia_cloud;
use Royalcms\Component\Printer\Contracts\Command;

/**
 * ECJia云打印客户端
 */
class Client
{   
    /**
     * 应用
     * @var \Royalcms\Component\Printer\App
     */
    protected $app;

    /**
     * 初始化
     * @param array $config APP配置类
     */
    public function __construct(App $app)
    {
        $this->app = $app;

        // 判断配置
        if (!$this->app->getAppKey() || !$this->app->getAppSecret()) {
            throw new Exception("ecjia printer configuration information: app_key or app_secret error");
        }
    }

    /**
     * 发起请求数据
     * @param  \Royalcms\Component\Printer\Contracts\Command $command 请求类
     * @return false|object
     */
    public function execute(Command $command)
    {
        $method        = $command->getMethod();
        $publicParams  = $this->getPublicParams();
        $serviceParams = $command->getParams();

        $params = array_merge(
            $publicParams,
            $serviceParams
        );

        // 签名
        $params['sign'] = $this->generateSign($publicParams);

        // 请求数据
        $resp = $this->curl(
            $method,
            $params
        );
   
        // 解析返回
        return $this->parseRep($resp);
    }

    /**
     * 解析返回数据
     * @return array|false
     */
    protected function parseRep($response)
    {
        if (is_ecjia_error($response)) {
            return $response;
        }
        if (count($response) === 0) {
            return true;
        }
        return $response;
    }

    /**
     * 返回公共参数
     * @return array 
     */
    protected function getPublicParams()
    {
        return [
            'app_key'     => $this->app->getAppKey(),
            'timestamp'   => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * 生成签名
     * @param  array  $params 待签参数
     * @return string         
     */
    protected function generateSign($params = [])
    {
        return $this->generateHmacSign($params);
    }

    /**
     * 按hmac方式生成签名
     * @param  array  $params 待签的参数
     * @return string         
     */
    protected function generateHmacSign($params = [])
    {
        static::sortParams($params);  // 排序

        $arr = [];
        foreach ($params as $k => $v) {
            $arr[] = $k . $v;
        }
        
        $str = implode('', $arr);
        
        return strtolower(hash_hmac('md5', $str, $this->app->getAppSecret()));
    }

    /**
     * 待签名参数排序
     * @param  array  &$params 参数
     * @return array         
     */
    protected static function sortParams(&$params = [])
    {
        ksort($params);
    }


    /**
     * curl请求
     * @param  string $method        string
     * @param  array|null $postFields 请求参数
     * @return [type]             [description]
     */
    protected function curl($method, $postFields = null)
    { 
        $cloud = ecjia_cloud::instance()->api($method)->data($postFields)->run();
        if (is_ecjia_error($cloud->getError())) {
            return $cloud->getError();
        }
        
        //获取每页可更新数
        $data = $cloud->getReturnData();

        return $data;
    }
}
