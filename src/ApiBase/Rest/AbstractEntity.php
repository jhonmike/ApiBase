<?php
/**
* Class AbstractEntity
*
* @author Jhon Mike Soares <https://github.com/jhonmike>
* @version 1.0
*/

namespace ApiBase\Rest;

use Zend\Stdlib\Hydrator;

abstract class AbstractEntity
{
    public function __construct($data = null)
    {
        $data = (array) $data;
        $hydrator = new Hydrator\ArraySerializable();
        $hydrator->hydrate($data, $this);
    }

    public function exchangeArray(array $data)
	{
        foreach ($data as $key => $value) {
            if(array_key_exists($key, $data))
                $this->$key = empty($data[$key]) ? $this->$key : $data[$key];
        }
	}

    public function exchangeObject($object)
    {
        foreach ($object as $key => $value) {
            if(property_exists($object, $key))
                $this->$key = empty($object->$key) ? $this->$key : $object->$key;
        }
    }

    public function getArrayCopy()
    {
        $data = array();
        foreach ($this as $key => $value) {
            if(property_exists($this, $key))
                $data[$key] = empty($this->$key) ? $this->$key : $this->$key;
        }
        return $data;
    }

    public function toArray()
    {
        $hydrator = new Hydrator\ArraySerializable();
        return $hydrator->extract($this);
    }
}
