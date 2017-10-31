<?php

namespace Royalcms\Component\Printer\Commands;

class PrinterCancelAll
{
    
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'printer/cancelall';
    
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'machine_code' => '',  // 必须 打印机终端号
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
    
}
