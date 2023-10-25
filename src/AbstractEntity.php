<?php

namespace Json\Normalizer\Hiraeth\Doctrine;

use Json\Normalizer;
use Hiraeth\Doctrine;
use Doctrine\Common\Proxy\Proxy;
use Doctrine\Common\Collections\Collection;
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
	public function __construct(Doctrine\ManagerRegistry $managers)
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
		$manager    = $this->managers->getManagerForClass($class);
		$meta_data  = $manager->getClassMetadata($class);

		if ($this('data') instanceof Proxy) {
			$this('data')->__load();
		}

		if ($this('nested')) {
			$fields = $meta_data->getIdentifierFieldNames();
		} else {
			$fields = array_unique(
				array_merge($meta_data->getFieldNames(), $meta_data->getAssociationNames())
			);
		}

		foreach ($fields as $field) {
			$data[$field] = $this->$field;
		}

		return Normalizer::prepare($data, $this('nested'));
	}
}
