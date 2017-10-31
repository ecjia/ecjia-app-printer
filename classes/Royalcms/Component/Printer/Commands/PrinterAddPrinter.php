<?php

namespace Royalcms\Component\Printer\Commands;

class PrinterAddPrinter
{
    
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'printer/addprinter';
    
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'machine_code' => '',  // 必须 打印机终端号
            'msign' => '',  // 必须 打印机终端密钥
            'mobilephone' => '',  // 必须 终端内部的手机号（方便充值）无手机号可传空值
            'printname' => '',  // 必须 打印机终端名称（自定义）
        ];
    }
    
    /**
     * 设置打印机终端号
     * @param string $value 打印机终端号
     */
    public function setMachineCode($value)
    {
        $this->params['machine_code'] = $value;
    
        return $this;
    }
    
    /**
     * 设置打印机终端密钥
     * @param string $value 打印机终端密钥
     */
    public function setMsign($value)
    {
        $this->params['msign'] = $value;
    
        return $this;
    }
    
    /**
     * 设置终端内部的手机号（方便充值）无手机号可传空值
     * @param string $value 终端内部的手机号
     */
    public function setMobilePhone($value)
    {
        $this->params['mobilephone'] = $value;
    
        return $this;
    }
    
    /**
     * 设置打印机终端名称（自定义）
     * @param string $value 打印机终端名称
     */
    public function setPrintName($value)
    {
        $this->params['printname'] = $value;
    
        return $this;
    }
    
}
