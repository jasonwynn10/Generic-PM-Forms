<?php
declare(strict_types=1);

namespace forms;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\form\CustomForm;
use pocketmine\form\element\Input;
use pocketmine\form\element\Label;
use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\Server;

class OpForm extends CustomForm {
	/**
	 * OpForm constructor.
	 */
	public function __construct() {
		$elements   = [];
		$elements[] = new Label("Enter a player's username to OP status");
		$elements[] = new Input("Username", "example12345");
		parent::__construct("Player OP Form", $elements);
	}

	/**
	 * @param Player $player
	 *
	 * @return null|Form
	 */
	public function onSubmit(Player $player) : ?Form {
		Server::getInstance()->dispatchCommand(new ConsoleCommandSender(), "op " . $this->getElement(1)->getValue());
		return null;
	}
}