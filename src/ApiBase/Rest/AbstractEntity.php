<?php
/**
* Class AbstractEntity
*
* @author Jhon Mike Soares <https://github.com/jhonmike>
* @version 1.0
*/

namespace ApiBase\Rest;

abstract class AbstractEntity
{
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
}
