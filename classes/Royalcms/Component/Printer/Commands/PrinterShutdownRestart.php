<?php

namespace Royalcms\Component\Printer\Commands;

use Royalcms\Component\Printer\Contracts\Command;
use Royalcms\Component\Printer\Request;

class PrinterShutdownRestart extends Request implements Command
{
    
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'printer/shutdownrestart';
    
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'machine_code' => '',  // 必须 打印机终端号
            'response_type' => '',  // 必须 重启:restart,关闭:shutdown
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
     * 重启:restart,关闭:shutdown
     * @param string $value 重启:restart,关闭:shutdown
     */
    public function setResponseType($value)
    {
        $this->params['response_type'] = $value;
    
        return $this;
    }
    
}
