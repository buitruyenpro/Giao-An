<?php
namespace Admin\Controller;

use Zend\Form\FormInterface;

use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zendvn\Paginator\Paginator as ZendvnPaginator;

class GroupController extends AbstractActionController
{
	protected $_table;
	protected $_form; 
	protected $_params 	= array(
			'paginator'		=> array(
					'itemCountPerPage'	=> 5,
					'pageRange'			=> 4,
			)
	);
	
	public function getTable(){
		if(empty($this->_table)) {
			$this->_table = $this->getServiceLocator()->get('Admin\Model\GroupTable');
		}
		return $this->_table;
	}
	
	public function getForm(){
		if(empty($this->_form)) {
			$this->_form = $this->getServiceLocator()->get('FormElementManager')->get('formAdminGroup');
		}
		return $this->_form;
	}
	
    public function indexAction()
    {
    	$ssFilter	= new Container(__NAMESPACE__);
    	
    	$this->_params['ssFilter']['order_by']				= ($ssFilter->offsetExists('order_by')) ? $ssFilter->offsetGet('order_by') : NULL;
    	$this->_params['ssFilter']['order']					= ($ssFilter->offsetExists('order')) ? $ssFilter->offsetGet('order') : NULL;
    	$this->_params['ssFilter']['filter_status']			= ($ssFilter->offsetExists('filter_status')) ? $ssFilter->offsetGet('filter_status') : NULL;
    	$this->_params['ssFilter']['filter_keyword_type']	= ($ssFilter->offsetExists('filter_keyword_type')) ? $ssFilter->offsetGet('filter_keyword_type') : NULL;
    	$this->_params['ssFilter']['filter_keyword_value']	= ($ssFilter->offsetExists('filter_keyword_value')) ? $ssFilter->offsetGet('filter_keyword_value') : NULL;
    	$this->_params['paginator']['currentPageNumber']	= $this->params()->fromRoute('page',1);
    
    	$total	= $this->getTable()->countItem($this->_params, array('task' => 'list-item'));
    	$items	= $this->getTable()->listItem($this->_params, array('task' => 'list-item'));
    	return new ViewModel(array(
    			'items'		=>	$items,
    			'paginator' => ZendvnPaginator::createPaginator($total, $this->_params['paginator']),
    			'ssFilter'	=> $this->_params['ssFilter']
    	));
    }
    
    public function filterAction()
    {
    	$request = $this->getRequest();
    	if($request->isPost()){
    		$ssFilter	= new Container(__NAMESPACE__);
    
    		$ssFilter->offsetSet('order_by', $request->getPost('order_by', 'id'));
    		$ssFilter->offsetSet('order', $request->getPost('order', 'ASC'));
    		$ssFilter->offsetSet('filter_status', $request->getPost('filter_status', null));
    		
    		$btnClear	= $request->getPost('btn-clear', null);
    		
    		$ssFilter->offsetSet('filter_keyword_type', $request->getPost('filter_keyword_type', null));
    		$ssFilter->offsetSet('filter_keyword_value', $request->getPost('filter_keyword_value', null));
    		
    		if($btnClear == 'btn-clear'){
    			$ssFilter->offsetUnset('filter_keyword_type');
    			$ssFilter->offsetUnset('filter_keyword_value');
    		}
    	}
    	return $this->redirect()->toRoute('adminRoute/default', array('controller' => 'group', 'action' => 'index'));
    }
    
    public function statusAction()
    {
    	$request = $this->getRequest();
    	if($request->isPost()){
    		$this->_params['id']		= $request->getPost('status_id', null);
    		$this->_params['status']	= $request->getPost('status_value', null);
    		if($this->_params['id'] > 0){
    			$this->getTable()->changeStatus($this->_params, array('task' => 'change-status'));
    		}
    		$this->flashMessenger()->addMessage('Trạng thái của phần tử đã được cập nhật thành công!');
    	}
    	return $this->redirect()->toRoute('adminRoute/default', array('controller' => 'group', 'action' => 'index'));
    }
    
    public function multiStatusAction()
    {
    	$request 	= $this->getRequest();
    	$message	= 'Vui lòng chọn vào phần tử mà bạn muốn thay đổi trạng thái!';
    	if($request->isPost()){
    		$this->_params['status']	= $request->getPost('status_value', null);
    		$this->_params['cid']		= $request->getPost('cid', null);
    		if(!empty($this->_params['cid'])){
    			$this->getTable()->changeStatus($this->_params, array('task' => 'change-multi-status'));
    			$message	= 'Trạng thái của phần tử đã được cập nhật thành công!';
    		}
    	}
    	$this->flashMessenger()->addMessage($message);
    	return $this->redirect()->toRoute('adminRoute/default', array('controller' => 'group', 'action' => 'index'));
    }
    
    public function orderingAction()
    {
    	$request 	= $this->getRequest();
    	$message	= 'Vui lòng chọn vào phần tử mà bạn muốn thay đổi thứ tự sắp xếp!';
    	if($request->isPost()){
    		$this->_params['cid']		= $request->getPost('cid', null);
    		$this->_params['ordering']		= $request->getPost('ordering', null);
    		if(!empty($this->_params['cid'])){
    			$this->getTable()->ordering($this->_params);
    			$message	= 'Thứ tự sắp xếp phần tử đã được cập nhật thành công!';
    		}
    	}
    	$this->flashMessenger()->addMessage($message);
    	return $this->redirect()->toRoute('adminRoute/default', array('controller' => 'group', 'action' => 'index'));
    }
    
    public function deleteAction()
    {
    	$request 	= $this->getRequest();
    	$message	= 'Vui lòng chọn vào phần tử mà bạn muốn xóa!';
    	if($request->isPost()){
    		$this->_params['cid']		= $request->getPost('cid', null);
    		if(!empty($this->_params['cid'])){
    			$this->getTable()->deleteItem($this->_params, array('task' => 'multi-delete'));
    			$message	= 'Các phần tử đã được xóa thành công!';
    		}
    	}
    	$this->flashMessenger()->addMessage($message);
    	return $this->redirect()->toRoute('adminRoute/default', array('controller' => 'group', 'action' => 'index'));
    }
    
    public function addAction()
    {
    	$myForm		= $this->getForm();
    	$request	= $this->getRequest();
    	if($request->isPost()){
    	
    		$data		= $this->getRequest()->getPost();
    		$myForm->setData($data);
    	
    		if($myForm->isValid()){
    			$this->_params['form']		= $myForm->getData();
    			$this->getTable()->saveItem($this->_params, array('task' => 'add-item'));
    			$this->flashMessenger()->addMessage('Dữ liệu đã được lưu thành công!');
    			return $this->redirect()->toRoute('adminRoute/default', array('controller' => 'group', 'action' => 'index'));
    		}
    	}
    	
    	return new ViewModel(array(
    			'myForm'	=> $myForm,
    	));
    }
    
    public function editAction()
    {
    	$myForm		= $this->getForm();
    	$request	= $this->getRequest();
    	
    	$id			= $this->params('id');
    	$item	= $this->getTable()->getItem(array('id' => $id));
    	$myForm->bind($item);
    	if($request->isPost()){
    		 
    		$data		= $this->getRequest()->getPost();
    		$myForm->setData($data);
    		 
    		if($myForm->isValid()){
    			$this->_params['form']		= $myForm->getData(FormInterface::VALUES_AS_ARRAY);
    			$this->getTable()->saveItem($this->_params, array('task' => 'edit-item'));
    			$this->flashMessenger()->addMessage('Dữ liệu đã được lưu thành công!');
    			return $this->redirect()->toRoute('adminRoute/default', array('controller' => 'group', 'action' => 'index'));
    		}
    	}
    	 
    	return new ViewModel(array(
    			'myForm'	=> $myForm,
    	));
    }
    
}
