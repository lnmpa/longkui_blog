<?php
namespace Api\Controller;

use Common\Controller\AppframeController;

class GuestbookController extends AppframeController{
	
	protected $guestbook_model;
	
	public function _initialize() {
		parent::_initialize();
		$this->guestbook_model=D("Common/Guestbook");
	}
	
	// 留言提交
	public function addmsg(){
		/*if(!sp_check_verify_code()){
			$this->error("验证码错误！");
		}*/
		
		if (IS_POST) {
			if ($this->guestbook_model->create()!==false) {
				$result=$this->guestbook_model->add();
				if ($result!==false) {
					$this->success(L('MESSAGE_SUCCESS'));
				} else {
					$this->error(L('MESSAGE_FAILED'));
				}
			} else {
				$this->error($this->guestbook_model->getError());
			}
		}
		
	}
}