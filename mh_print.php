<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 打印机管理
 */
class mh_print extends ecjia_merchant
{
    public function __construct()
    {
        parent::__construct();

        //全局JS和CSS
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');
        
        RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
        RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);
                
        RC_Script::enqueue_script('ecjia-mh-editable-js');
        RC_Style::enqueue_style('ecjia-mh-editable-css');
        
        RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
        RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));

        RC_Style::enqueue_style('fontello', RC_Uri::admin_url('statics/lib/fontello/css/fontello.css'));

        RC_Style::enqueue_style('nouislider', RC_App::apps_url('statics/css/jquery.nouislider.css', __FILE__), array());
        RC_Script::enqueue_script('nouislider', RC_App::apps_url('statics/js/jquery.nouislider.min.js', __FILE__), array(), false, false);

        RC_Style::enqueue_style('merchant_printer', RC_App::apps_url('statics/css/merchant_printer.css', __FILE__), array());
        RC_Style::enqueue_style('printer', RC_App::apps_url('statics/css/printer.css', __FILE__), array());
        RC_Script::enqueue_script('mh_printer', RC_App::apps_url('statics/js/mh_printer.js', __FILE__), array(), false, false);
    }

    /**
     * 打印机管理
     */
    public function init()
    {
        $this->admin_priv('store_printer_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('小票打印设置'));

        $this->assign('ur_here', '小票打印设置');
        $this->assign('add_url', RC_Uri::url('printer/mh_print/add', array('store_id' => $_SESSION['store_id'])));

        $printer_list = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->orderBy('id', 'asc')->get();
        $this->assign('list', $printer_list);

        $statics_url = RC_App::apps_url('statics/', __FILE__);
        $this->assign('statics_url', $statics_url);
        $this->assign('type', 'printer_manage');

        $this->display('printer_list.dwt');
    }

    public function view()
    {
        $this->admin_priv('store_staff_update');

        $id   = intval($_GET['id']);
        $info = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        if (empty($info)) {
            return $this->showmessage('该打印机不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (!empty($info['printer_logo'])) {
            $info['printer_logo'] = RC_Upload::upload_url($info['printer_logo']);
        }
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('查看打印机'));

        $this->assign('action_link', array('href' => RC_Uri::url('printer/mh_print/init'), 'text' => '打印机管理'));
        $this->assign('ur_here', '查看打印机');
        $this->assign('info', $info);

        $statics_url = RC_App::apps_url('statics/', __FILE__);
        $this->assign('statics_url', $statics_url);
        $this->assign('control_url', RC_Uri::url('printer/mh_print/voice_control', array('id' => $id)));

        $count = $this->get_print_count();
        $this->assign('count', $count);

        $this->display('printer_view.dwt');
    }

    public function cancel()
    {
        $this->admin_priv('store_staff_update', ecjia::MSGTYPE_JSON);
        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $this->showmessage('取消成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    public function close()
    {
        $this->admin_priv('store_staff_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('online_status' => 0));
        $this->showmessage('关闭成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    public function voice_control()
    {
        $id    = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $type  = isset($_POST['type']) ? trim($_POST['type']) : '';
        $voice = isset($_POST['voice']) ? intval($_POST['voice']) : 0;

        if (!empty($type)) {
            $type = $type == 'buzzer' ? 'horn' : 'buzzer';
            RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('voice_type' => $type));
            $this->showmessage('响铃类型修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
        } else if (!empty($voice)) {
            RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('voice' => $voice));
            $this->showmessage('音量修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
        }
    }

    public function record_list()
    {
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('打印记录'));
        $this->assign('ur_here', '打印记录');

        $record_list = $this->get_record_list();
        $this->assign('record_list', $record_list);
        $this->assign('type', 'printer_record');
        
        $this->display('printer_record_list.dwt');
    }

    public function reprint()
    {
        $this->admin_priv('store_staff_update', ecjia::MSGTYPE_JSON);

    }

    public function edit_printer_name()
    {
        $this->admin_priv('store_staff_update', ecjia::MSGTYPE_JSON);

        $id           = !empty($_POST['pk']) ? intval($_POST['pk']) : 0;
        $printer_name = !empty($_POST['value']) ? trim($_POST['value']) : '';
        if (empty($printer_name)) {
            return $this->showmessage('请输入打印机名称', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('printer_machine')->where('id', $id)->update(array('printer_name' => $printer_name));
        $this->showmessage('打印机名称修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function edit_printer_mobile()
    {
        $this->admin_priv('store_staff_update', ecjia::MSGTYPE_JSON);
        $id             = !empty($_POST['pk']) ? intval($_POST['pk']) : 0;
        $printer_mobile = !empty($_POST['value']) ? trim($_POST['value']) : '';
        if (empty($printer_mobile)) {
            return $this->showmessage('请输入手机卡号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('printer_machine')->where('id', $id)->update(array('printer_mobile' => $printer_mobile));
        $this->showmessage('手机卡号修改成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function upload_logo()
    {
        $this->admin_priv('store_staff_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_POST['id']) ? intval($_POST['id']) : 0;

        $file_name = '';
        /* 处理上传的LOGO图片 */
        if ((isset($_FILES['printer_logo']['error']) && $_FILES['printer_logo']['error'] == 0) || (!isset($_FILES['printer_logo']['error']) && isset($_FILES['printer_logo']['tmp_name']) && $_FILES['printer_logo']['tmp_name'] != 'none')) {
            $upload     = RC_Upload::uploader('image', array('save_path' => 'data/printer', 'auto_sub_dirs' => false));
            $image_info = $upload->upload($_FILES['printer_logo']);

            if (!empty($image_info)) {
                $file_name = $upload->get_position($image_info);
            } else {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $info = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        //删除旧logo
        if (!empty($info['printer_logo'])) {
            $disk = RC_Filesystem::disk();
            $disk->delete(RC_Upload::upload_path() . $info['printer_logo']);
        }

        RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('printer_logo' => $file_name));
        $this->showmessage('上传成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    public function del_file()
    {
        $this->admin_priv('store_staff_update', ecjia::MSGTYPE_JSON);

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $info = RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->first();
        if (!empty($info['printer_logo'])) {
            $disk = RC_Filesystem::disk();
            $disk->delete(RC_Upload::upload_path() . $info['printer_logo']);
        }

        RC_DB::table('printer_machine')->where('store_id', $_SESSION['store_id'])->where('id', $id)->update(array('printer_logo' => ''));
        $this->showmessage('删除成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/mh_print/view', array('id' => $id))));
    }

    private function get_record_list()
    {
        $db_printer_view = RC_DB::table('printer_printlist as p')
            ->leftJoin('printer_machine as m', RC_DB::raw('p.printer_code'), '=', RC_DB::raw('m.printer_code'))
        	->where(RC_DB::raw('p.store_id'), $_SESSION['store_id']);

        $count = $db_printer_view->count();
        $page  = new ecjia_page($count, 10, 5);
        $data  = $db_printer_view->selectRaw('p.*, m.printer_name')->take(10)->skip($page->start_id - 1)->orderBy('id', 'desc')->get();

        return array('item' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

    private function get_print_count()
    {
        $week_start_time     = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date("m"), RC_Time::local_date("d") - RC_Time::local_date("w") + 1, RC_Time::local_date("Y"));
        $count['week_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $_SESSION['store_id'])
            ->where('printer_code', $info['printer_code'])
            ->where('status', 1)
            ->where('print_time', '>', $week_start_time)
            ->where('print_time', '<', RC_Time::gmtime())
            ->SUM('print_count');

        $now                        = RC_Time::gmtime();
        $start                      = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date("m", $now), RC_Time::local_date("d", $now), RC_Time::local_date("Y", $now));
        $count['today_print_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $_SESSION['store_id'])
            ->where('printer_code', $info['printer_code'])
            ->where('status', 1)
            ->where('print_time', '>', $start)
            ->where('print_time', '<', RC_Time::gmtime())
            ->SUM('print_count');
        $count['today_unprint_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $_SESSION['store_id'])
            ->where('printer_code', $info['printer_code'])
            ->where('status', '!=', 1)
            ->where('print_time', '>', $start)
            ->where('print_time', '<', RC_Time::gmtime())
            ->SUM('print_count');

        return $count;
    }
}

//end
