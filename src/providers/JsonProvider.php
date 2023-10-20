<?php

namespace Hiraeth\Json;

use Json;
use Hiraeth;

/**
 * {@inheritDoc}
 */
class JsonProvider implements Hiraeth\Provider
{
	/**
	 * {@inheritDoc}
	 */
	static public function getInterfaces(): array
	{
		return [
			Hiraeth\Application::class
		];
	}


	/**
	 * {@inheritDoc}
	 */
	public function __invoke(object $instance, Hiraeth\Application $app): object
	{
		Json\Normalizer::setContainer($app);

		return $instance;
	}
}
