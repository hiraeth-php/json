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
	public function jsonSerialize(): Normalizer
	{
		return Normalizer::prepare($this->getValues());
	}
}
