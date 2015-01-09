<?php
/**
* Class AbstractMapper
*
* @author Jhon Mike Soares <http://www.jhonmike.com.br>
* @version 1.0
*/

namespace ApiBase\Rest;

use Zend\Db\TableGateway\TableGateway;

abstract class AbstractMapper
{
	protected $tableGateway;

	public function fetchAll($data)
	{
		if (count($data) > 0) {
			$resultSet = $this->tableGateway->select()->where($data);
		} else
			$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function fetchOne($id)
	{
		$id = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Item com o id {$id}, não encontrado");
		}
		return $row;
	}

	public function save($entity)
	{
		$id = (int) $entity->id;
		if ($id === 0) {
			$res = $this->tableGateway->insert($entity->toArray());
			$entity->id = $this->tableGateway->lastInsertValue;
		} else {
			if ($this->fetchOne($id)) {
				$res = $this->tableGateway->update($entity->toArray(), array('id' => $id));
			}
		}
		return $entity->toArray();
	}

	public function delete($id)
	{
		$id = (int) $id;
		return $this->tableGateway->delete(array('id' => $id));
	}
}
