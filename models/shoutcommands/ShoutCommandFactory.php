<?php

namespace app\models\shoutcommands;

class ShoutCommandFactory {
	
	/**
	 * Returns an object implementing ShoutCommandInterface.
	 * @param type $commandName
	 * @return ShoutCommandInterface
	 */
	public function create ($commandName) {
		$className = 'app\models\shoutcommands\\' . ucfirst(strtolower($commandName)) . 'Command';
		$class = new \ReflectionClass($className);
		if (!$class->isInstantiable() || !$class->implementsInterface('\app\models\shoutcommands\ShoutCommand')) {
			throw new \InvalidArgumentException('ShoudCommand not found or not valid.');
		}
		$object = $class->newInstanceArgs();
		return $object;
	}
	
}
