<?php
/**
 * Created by PhpStorm.
 * User: Difidus
 * Date: 19/08/2015
 * Time: 23:03
 */

namespace General\Hydrator;


use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\Hydrator\HydratorInterface;

class DefaultHydrator implements HydratorInterface
{
	/**
	 * Inject $data's data in $object
	 * @param array $data
	 * @param object $object
	 * @return object
	 */
	public function hydrate(array $data, $object)
	{
		foreach ($data as $k => $v) {
			if (method_exists($object, 'set' . ucfirst($k))) {
				$setter = 'set' . ucfirst($k);
				$object->$setter($v);
			} else {
				$object->$k = $v;
			}
		}
		return $object;
	}

	/**
	 * Convert an object into an array
	 * @param object $object
	 * @return array
	 */
	public function extract($object)
	{
		if (is_object($object))
			$object = $this->extractObject($object);
		else if (is_array($object))
			$object = $this->extractArray($object);
		return $object;
	}

	private function extractArray(&$array)
	{
		foreach ($array as $k => $item) {
			$array[$k] = $this->extract($item);
		}
		return $array;
	}

	private function extractObject($object)
	{
		$arr = array();
		$props = array();
		//Doctrine Lazy load class
		if ($object instanceof \stdClass) {
			return $object;
		} else if ($object instanceof \DateTime) {
			return $object->format('Y-m-d H:i:s');
		} else if ($object instanceof \Doctrine\ORM\Proxy\Proxy) {
			$reflectClass = new \ReflectionClass(get_parent_class($object));
			$props = $reflectClass->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE);
		} else {
			$reflect = new \ReflectionObject($object);
			$props = ArrayUtils::merge(
				$props,
				$reflect->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE)
			);
		}
		foreach ($props as $prop) {
			if (isset($object->{$prop->getName()})) {
				$propval = $object->{$prop->getName()};
			} else if (method_exists($object, 'get' . ucfirst($prop->getName()))) {
				$getter = 'get' . ucfirst($prop->getName());
				$propval = $object->$getter();
			}
			if (isset($propval))
				$arr[$prop->getName()] = $propval;
		}
		return $arr;
	}
}