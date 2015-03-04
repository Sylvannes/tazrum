<?php

namespace app\models\shoutcommands;

interface ShoutCommand {
	
	/**
	 * @param array $arguments The arguments that the user entered after typing
	 * the command.
	 * @return boolean Whether the execution was successful.
	 */
	public function execute (array $arguments);
}
