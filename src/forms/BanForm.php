<?php
declare(strict_types=1);

namespace forms;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\form\CustomForm;
use pocketmine\form\element\Input;
use pocketmine\form\element\Label;
use pocketmine\form\element\Toggle;
use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\Server;

class BanForm extends CustomForm {
	/**
	 * BanForm constructor.
	 */
	public function __construct() {
		$elements   = [];
		$elements[] = new Label("Enter a player's username to ban from the server");
		$elements[] = new Input("Username", "example12345");
		$elements[] = new Input("Reason", "Why were they banned?");
		$elements[] = new Toggle("Ban IP");
		parent::__construct("Ban Form", $elements);
	}

	/**
	 * @param Player $player
	 *
	 * @return null|Form
	 */
	public function onSubmit(Player $player) : ?Form {
		$server = Server::getInstance();
		$banned = $server->getPlayer($this->getElement(1)->getValue());
		if($banned !== null) {
			$server->dispatchCommand(new ConsoleCommandSender(), "ban " . $banned->getName() . " " . $this->getElement(2)->getValue());
			if($this->getElement(3)->getValue()) {
				$server->dispatchCommand(new ConsoleCommandSender(), "ipban " . $banned->getName() . " " . $this->getElement(2)->getValue());
			}
		} else {
			$player->sendMessage("Invalid username!");
		}
		return null;
	}
}