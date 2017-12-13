<?php

namespace Ecjia\App\Printer;

use ecjia_config;

class PrinterManager
{
    private $appKey;
    private $appSecret;
    
    protected $printer;
    
    public function __construct($appKey = null, $appSecret = null)
    {
        $this->appKey = $appKey ?: ecjia_config::get('printer_key');
        $this->appSecret = $appSecret ?: ecjia_config::get('printer_secret');
        $this->printer = royalcms('printer');
        
        $config = [
            'app_key' => $this->appKey,
            'app_secret' => $this->appSecret,
        ];
        $this->printer->configure($config);
    }
    
    
    /**
     * 设置打印回调地址
     * @param string $finish 打印完成推送地址
     * @param string $getOrder 接单拒单推送地址
     * @param string $printStatus 打印机状态推送推送地址
     */
    public function setNotify($finish = null, $getOrder = null, $printStatus = null)
    {
        $oauth_finish = $finish ?: ecjia_config::get('printer_print_push');
        $oauth_getOrder = $getOrder ?: ecjia_config::get('printer_order_push');
        $oauth_printStatus = $printStatus ?: ecjia_config::get('printer_status_push');
        
        $resp = $this->printer->request('yly/printer/setnotify', function ($req) use ($oauth_finish, $oauth_getOrder, $oauth_printStatus) {
        	$req->setOauthFinish($oauth_finish);
        	$req->setOauthGetOrder($oauth_getOrder);
        	$req->setOauthPrintStatus($oauth_printStatus);
        });
        
        return $resp;
    }
    
    
    public function addPrinter()
    {
        
    }
    
    
}