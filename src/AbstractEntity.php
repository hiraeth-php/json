<?php

namespace Json\Normalizer\Hiraeth\Doctrine;

use Json\Normalizer;
use Doctrine\Common\Proxy\Proxy;
use Hiraeth\Doctrine\ManagerRegistry;
/**
 *
 */
class AbstractEntity extends Normalizer
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
	public function jsonSerialize(): Normalizer
	{
		$data       = array();
		$class      = get_class($this('data'));
		$manager    = $this->managers->getManagerForClass($class ?: NULL);
		$meta_data  = $manager->getClassMetadata($class ?: NULL);

		$manager->getUnitOfWork()->initializeObject($this('data'));

		if ($this('nested')) {
			$fields = $meta_data->getIdentifierFieldNames();
		} else {
			$fields = array_unique(
				array_merge($meta_data->getFieldNames(), $meta_data->getAssociationNames())
			);
		}

		foreach ($fields as $field) {
			if (strpos($field, '.') !== false) {
				$parts = explode('.', $field);
				$field = $parts[0];
			}

			$data[$field] = $this->$field;
		}

		return Normalizer::prepare($data, $this('nested'));
	}
}
