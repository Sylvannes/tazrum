<?php

namespace app\models\shoutcommands;

use app\models\Shout;
use app\models\shoutcommands\ShoutCommand;

use \Yii;

class DebugCommand implements ShoutCommand {

	/**
	 * @param array $arguments The arguments that the user entered after typing
	 * the command.
	 * @return boolean Whether the execution was successful.
	 */
	public function execute (array $arguments) {
		$shout = new Shout();
		$shout->user_id = Yii::$app->user->id;
		$shout->text = 'This is a debug shout, the entered arguments are: ' . implode(' ', $arguments);
		return $shout->save();
	}

}