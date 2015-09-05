<?php
/**
 * Created by PhpStorm.
 * User: Difidus
 * Date: 01/09/2015
 * Time: 23:56
 */

namespace General\Doctrine;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Entity implements ServiceLocatorAwareInterface
{
	use ServiceLocatorAwareTrait;

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

	public function exchangeArray($data)
	{
		foreach ($data as $k => $val) {
			$setter = 'set' . ucfirst($k);
			if (method_exists($this, $setter))
				$this->$setter($val);
		}
	}
}