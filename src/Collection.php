<?php

namespace Json\Normalizer\Doctrine\Common\Collections;

use Json;

/**
 *
 */
class Collection extends Json\Normalizer
{
	/**
	 *
	 */
	public function jsonSerialize(): mixed
	{
		return $this->getValues();
	}
}
