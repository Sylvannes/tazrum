<?php

namespace app\models\forms;

use app\models\Shout;
use app\models\shoutcommands\ShoutCommandFactory;

use Yii;
use yii\base\Model;

/**
 * ShoutForm is the model that handles shouts.
 */
class ShoutForm extends Model {

    public $text;

    /**
     * @return array the validation rules.
     */
    public function rules () {
        return [
            ['text', 'required'],
            ['text', 'string', 'min' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels () {
        return [
            'text' => 'Shout'
        ];
    }

	/**
	 * @return boolean
	 */
	public function create () {

		if ($this->isCommand()) {
			\Yii::trace('Shout recognized as a command.', __METHOD__);
			$shoutCommandFactory = new ShoutCommandFactory();
			try {
				$shoutCommand = $shoutCommandFactory->create($this->getCommandName());
				$result = $shoutCommand->execute($this->getCommandArguments());
			} catch (\Exception $e) {
				\Yii::trace('ShoutCommand exception: ' . $e->getMessage(), __METHOD__);
				return false;
			}
			return $result;
		} else {
			$shout = new Shout();
			$shout->user_id = Yii::$app->user->id;
			$shout->text = $this->text;

			if (!$shout->validate() || !$shout->save()) {
				\Yii::trace(print_r($shout->getErrors(), true), __METHOD__);
				\Yii::trace(print_r($shout, true), __METHOD__);
				return false;
			}

			return true;
		}

	}

	/**
	 * Whether the currently entered text is recognized as a command.
	 * @return boolean
	 */
	protected function isCommand () {
		return strpos(trim($this->text), '/') === 0;
	}

	/**
	 * Returns the name of the entered command, i.e. the first word without the
	 * leading slash.
	 *
	 * If the shout is "/pm TaZ This is a shout", the command name is "pm".
	 *
	 * @return string
	 */
	protected function getCommandName () {
		$words = explode(' ', $this->text, 2);
		return substr($words[0], 1);
	}

	/**
	 * Returns the arguments of the currently entered shout.
	 * @return array of strings
	 */
	protected function getCommandArguments () {
		$words = explode(' ', $this->text);
		array_shift($words);
		return $words;
	}

}
