<?php

namespace Json\Normalizer\Doctrine\Common\Collections;

use Json\Normalizer;

/**
 *
 */
class Collection extends Normalizer
{
	/**
	 *
	 */
	public function jsonSerialize(): mixed
	{
		return $this->getValues();
	}
}
