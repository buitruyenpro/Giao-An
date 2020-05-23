<?php
namespace Admin\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;

class GroupTable extends AbstractTableGateway {
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway	= $tableGateway;
	}
	
	public function countItem($arrParam = null, $options = null){
		if($options['task'] == 'list-item') {
			
			$result	= $this->tableGateway->select(function (Select $select) use ($arrParam){
				$ssFilter	= $arrParam['ssFilter'];
				
				if(!empty($ssFilter['filter_status'])){
					$status	= ($ssFilter['filter_status'] == 'active') ? 1 : 0;
					$select->where->equalTo('status',$status);
				}
				
				if(!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
					if($ssFilter['filter_keyword_type'] != 'all') {
						$select->where->like($ssFilter['filter_keyword_type'], '%'.$ssFilter['filter_keyword_value'].'%');
					}else{
						$select->where->like('name', '%'.$ssFilter['filter_keyword_value'].'%');
						$select->where->or->equalTo('id', $ssFilter['filter_keyword_value']);
					}
				}
				
			})->count();
			
		}
		return $result;
	}
	
	public function listItem($arrParam = null, $options = null){
		
		if($options['task'] == 'list-item') {
			
			$result	= $this->tableGateway->select(function (Select $select) use ($arrParam){
				$paginator	= $arrParam['paginator'];
				$ssFilter	= $arrParam['ssFilter'];
				
				$select->columns(array(
							'id', 'name', 'status', 'ordering', 'created', 'created_by'
						))
						->limit($paginator['itemCountPerPage'])
						->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
				
				if(!empty($ssFilter['order_by']) && !empty($ssFilter['order'])){
						$select->order(array($ssFilter['order_by'] . ' ' . $ssFilter['order']));
				}
				
				if(!empty($ssFilter['filter_status'])){
					$status	= ($ssFilter['filter_status'] == 'active') ? 1 : 0;
					$select->where->equalTo('status',$status);
				}
				
				if(!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
					if($ssFilter['filter_keyword_type'] != 'all') {
						$select->where->like($ssFilter['filter_keyword_type'], '%'.$ssFilter['filter_keyword_value'].'%');
					}else{
						$select->where->NEST
									  ->like('name', '%'.$ssFilter['filter_keyword_value'].'%')
									  ->or
									  ->equalTo('id', $ssFilter['filter_keyword_value'])
									  ->UNNEST;
					}
				}
				
				
			});
			
		}
		
		return $result;
	}
	
	public function changeStatus($arrParam = null, $options = null){
		if($options['task'] == 'change-status') {
			$data 	= array('status' => ($arrParam['status'] == 1) ? 0 : 1);
			$where	= array('id' => $arrParam['id']);
			$this->tableGateway->update($data, $where);
		}

		if($options['task'] == 'change-multi-status') {
			$data 	= array('status' => $arrParam['status']);
			$cid	= implode(',', $arrParam['cid']);
			$where	= array('id IN ('.$cid.')');
			$this->tableGateway->update($data, $where);
		}
	}
	
	public function getItem($arrParam = null, $options = null){
	
		if($options == null) {
			$result	= $this->tableGateway->select(function (Select $select) use ($arrParam){
					$select->columns(array('id', 'name', 'ordering', 'status'));
					$select->where->equalTo('id', $arrParam['id']);
			})->current();
		}
	
		return $result;
	}
	
	public function ordering($arrParam = null, $options = null){
	
		if($options == null) {
			foreach ($arrParam['cid'] as $id) {

				$data 	= array('ordering' => $arrParam['ordering'][$id]);
				$where	= array('id' => $id);
				$this->tableGateway->update($data, $where);
			}
		}
	
	}
	
	public function deleteItem($arrParam = null, $options = null){
	
		if($options == null) {
			$this->tableGateway->delete(array('id' => $arrParam['id']));
		}
		
		if($options['task'] == 'multi-delete') {
			foreach ($arrParam['cid'] as $id) {
				$this->tableGateway->delete(array('id' => $id));
			}
		}
	
	}
	
	public function saveItem($arrParam = null, $options = null){
		if($options['task'] == 'add-item') {
			$data	= array(
				'name'		=> $arrParam['form']['name'],		
				'ordering'	=> $arrParam['form']['ordering'],		
				'status'	=> ($arrParam['form']['status'] == 'active') ? 1 : 0,		
				'created'	=> date('Y-m-d H:i:s'),		
			);
			
			$this->tableGateway->insert($data);
		}
		if($options['task'] == 'edit-item') {
			$data	= array(
				'name'		=> $arrParam['form']['name'],		
				'ordering'	=> $arrParam['form']['ordering'],		
				'status'	=> ($arrParam['form']['status'] == 'active') ? 1 : 0,		
				'modified'	=> date('Y-m-d H:i:s'),		
			);
				
			$this->tableGateway->update($data, array('id' => $arrParam['form']['id']));
		}
	}
}