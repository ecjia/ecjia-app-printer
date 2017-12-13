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
    
    /**
     * 添加打印机
     * @param string $print_name    设置打印机终端名称
     * @param string $machine_code  设置打印机终端号
     * @param string $machine_secret设置打印机终端密钥
     * @param string $phone         设置终端内部的手机号
     */
    public function addPrinter($print_name, $machine_code, $machine_secret, $phone = '')
    {
        $resp = $this->printer->request('yly/printer/addprinter', function ($req) use ($print_name, $machine_code, $machine_secret, $phone) {
            $req->setMachineCode($machine_code);
            $req->setMsign($machine_secret);
            $req->setMobilePhone($phone);
            $req->setPrintName($print_name);
        });
        
        return $resp;
    }
    
    /**
     * 删除打印机
     * @param string $machine_code  设置打印机终端号
     */
    public function deletePrinter($machine_code)
    {
        $resp = $this->printer->request('yly/printer/deleteprinter', function ($req) use ($machine_code) {
            $req->setMachineCode($machine_code);
        });
        
        return $resp;
    }
    
    /**
     * 关机
     * @param string $machine_code
     */
    public function shutdown($machine_code)
    {
        $resp = $this->printer->request('yly/printer/shutdownrestart', function ($req) use ($machine_code) {
            $req->setMachineCode($machine_code);
            $req->setResponseType('shutdown');
        });
        
        return $resp;
    }
    
    /**
     * 重启
     * @param string $machine_code
     */
    public function restart($machine_code)
    {
        $resp = $this->printer->request('yly/printer/shutdownrestart', function ($req) use ($machine_code) {
            $req->setMachineCode($machine_code);
            $req->setResponseType('restart');
        });
        
        return $resp;
    }
    
    /**
     * 上传LOGO
     */
    public function setIcon($machine_code, $img_url)
    {
        $resp = $this->printer->request('yly/printer/seticon', function ($req) use ($machine_code, $img_url) {
            $req->setMachineCode($machine_code);
            $req->setImgUrl($img_url);
        });
        
        return $resp;
    }
    
    /**
     * 删除LOGO
     */
    public function deleteIcon($machine_code)
    {
        $resp = $this->printer->request('yly/printer/deleteicon', function ($req) use ($machine_code) {
            $req->setMachineCode($machine_code);
        });
        
        return $resp;
    }
    
    
    /**
     * 获取机型软硬件版本
     */
    public function getVersion($machine_code)
    {
        $resp = $this->printer->request('yly/printer/getversion', function ($req) use ($machine_code) {
            $req->setMachineCode($machine_code);
        });
    
        return $resp;
    }
    
    
    
}