<?php
class ControllerExtensionPaymentpaydo extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('extension/payment/paydo');

		$this->document->setTitle = $this->language->get('heading_title');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('paydo', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			if (isset($this->request->post['save_stay']) && $this->request->post['save_stay']){
				$this->response->redirect($this->url->link('extension/payment/paydo', 'token=' . $this->session->data['token'], true));
			}
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_card'] = $this->language->get('text_card');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_result_url'] = $this->language->get('text_result_url');
		$data['text_success_url'] = $this->language->get('text_success_url');
		$data['text_fail_url'] = $this->language->get('text_fail_url');
		$data['text_save_and_stay'] = $this->language->get('text_save_and_stay');
        $data['entry_status'] = $this->language->get('entry_status');

		$data['entry_login'] = $this->language->get('entry_login');
		$data['entry_paydo_key'] = $this->language->get('entry_paydo_key');

		// URL
		$data['copy_result_url'] 	= HTTP_CATALOG . 'index.php?route=extension/payment/paydo/callback';
		$data['copy_success_url']	= HTTP_CATALOG . 'index.php?route=checkout/success';
		$data['copy_fail_url'] 	= HTTP_CATALOG . 'index.php?route=checkout/failure';

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

		//

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		//
		if (isset($this->error['login'])) {
			$data['error_login'] = $this->error['login'];
		} else {
			$data['error_login'] = '';
		}

		if (isset($this->error['password1'])) {
			$data['error_password1'] = $this->error['password1'];
		} else {
			$data['error_password1'] = '';
		}


		$data['action'] = $this->url->link('extension/payment/paydo', 'token=' . $this->session->data['token'], true);
		$data['update'] = $this->url->link('extension/payment/paydo', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/payment/paydo', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);

		//
		if (isset($this->request->post['paydo_login'])) {
			$data['paydo_login'] = $this->request->post['paydo_login'];
		} else {
			$data['paydo_login'] = $this->config->get('paydo_login');
		}

		if (isset($this->request->post['paydo_key'])) {
			$data['paydo_key'] = $this->request->post['paydo_key'];
		} else {
			$data['paydo_key'] = $this->config->get('paydo_key');
		}

        if (isset($this->request->post['paydo_status'])) {
            $data['paydo_status'] = $this->request->post['paydo_status'];
        } else {
            $data['paydo_status'] = $this->config->get('paydo_status');
        }

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/paydo.tpl', $data));

	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/paydo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['paydo_login']) {
			$this->error['login'] = $this->language->get('error_login');
		}

		if (!$this->request->post['paydo_key']) {
			$this->error['password1'] = $this->language->get('error_password1');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>