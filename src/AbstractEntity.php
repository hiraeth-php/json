<?php

namespace Json\Normalizer\Hiraeth\Doctrine;

use Json;
use Doctrine\Common\Proxy\Proxy;
use Hiraeth\Doctrine\ManagerRegistry;

/**
 *
 */
class AbstractEntity extends Json\Normalizer
{
	/**
	 * @var ManagerRegistry
	 */
	protected $managers;

	/**
	 *
	 */
	public function __construct(ManagerRegistry $managers)
	{
		$this->managers = $managers;
	}

	/**
	 *
	 */
	public function jsonSerialize(): Json\Normalizer
	{
		$data       = array();
		$class      = get_class($this('data'));
		$manager    = $this->managers->getManagerForClass($class);
		$meta_data  = $manager->getClassMetadata($class);
		$identity   = $meta_data->getIdentifierFieldNames();

		foreach ($meta_data->getFieldNames() as $field) {
			if ($this('nested')) {
				if (!in_array($field, $identity)) {
					continue;
				}
			}

			$data[$field] = $meta_data->getFieldValue($this('data'), $field);
		}

		if ($this('nested')) {
			$fields = $identity;
		} else {
			$fields = array_merge($meta_data->getFieldNames(), $meta_data->getAssociationNames());
		}

		foreach ($fields as $field) {
			$data[$field] = $meta_data->getFieldValue($this('data'), $field);

			if ($data[$field] instanceof Proxy) {
				$data[$field]->__load();
			}
		}

		return static::prepare($data, $this('nested'));
	}
}
