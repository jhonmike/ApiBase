<?php
/**
* Class AbstractMapper
*
* @author Jhon Mike Soares <http://www.jhonmike.com.br>
* @version 1.0
*/

namespace ApiBase\Rest;

abstract class AbstractMapper
{
	protected $sql;
	protected $tableGateway;

	public function fetchAll($data)
	{
		$resultSet = $this->sql->select();

		if (count($data) > 0)
			$resultSet->where($data);
		
		// echo $this->sql->getSqlstringForSqlObject($resultSet); exit();

		$statement = $this->sql->prepareStatementForSqlObject($resultSet);
		return $statement->execute();
	}

	public function fetchOne($id)
	{
		$id = (int) $id;

		$rowset = $this->sql->select()->where(array('id' => $id));
		// echo $this->sql->getSqlstringForSqlObject($rowset); exit();
		$statement = $this->sql->prepareStatementForSqlObject($rowset);
		$row = $statement->execute();

		if (!$row)
			throw new \Exception("Item com o id {$id}, não encontrado");

		return $row->current();
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