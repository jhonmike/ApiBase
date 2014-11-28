<?php
/**
* @author Jhon Mike Soares <http://www.jhonmike.com.br>
* @version 1.0
*/

namespace ApiBase\Hydrator;

use DateTime;
use Zend\Stdlib\Hydrator\Strategy\DefaultStrategy;

class DateTimeStrategy extends DefaultStrategy
{
    /**
     * Convert a string value into a DateTime object
     */
    public function hydrate($value)
    {
        if (is_string($value) && "" === $value) {
            $value = null;
        } elseif (is_string($value)) {
            $value = new DateTime($value);
        } else {
            $value = new DateTime('now');
        }
 
        return $value;
    }

    /**
     * Convert a DateTime object into a string value
     */
    public function extract($value)
    {
        if (is_object($value)) {
            $value = $value->format('Y-m-d H:i:s');
        } elseif (is_string($value)) {
            $value = new DateTime($value);
            $value = $value->format('Y-m-d H:i:s');
        }

        return $value;
    }
}