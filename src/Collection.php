<?php

namespace Json\Normalizer\Doctrine\Common\Collections;

use API;

/**
 *
 */
class Collection extends API\Resource
{
	/**
	 *
	 */
	public function jsonSerialize(): mixed
	{
		return $this->getValues();
	}
}
