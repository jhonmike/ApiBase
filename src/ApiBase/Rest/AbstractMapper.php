<?php
/**
* Class AbstractMapper
*
* @author Jhon Mike Soares <https://github.com/jhonmike>
* @version 1.0
*/

namespace ApiBase\Rest;

use Zend\Db\TableGateway\TableGateway;

abstract class AbstractMapper
{
	protected $tableGateway;

	public function fetchAll()
	{
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
			$res = $this->tableGateway->insert($entity->getArrayCopy());
			$entity->id = $this->tableGateway->lastInsertValue;
		} else {
			$res = $this->tableGateway->update($entity->getArrayCopy(), $entity->id);
		}
		return $entity->getArrayCopy();
	}
}