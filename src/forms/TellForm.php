<?php
declare(strict_types=1);

namespace forms;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\form\CustomForm;
use pocketmine\form\element\Dropdown;
use pocketmine\form\element\Input;
use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\Server;

class TellForm extends CustomForm {
	/**
	 * TellForm constructor.
	 */
	public function __construct() {
		$elements = [];
		$players  = [];
		foreach(Server::getInstance()->getOnlinePlayers() as $player) {
			$players[] = $player->getName();
		}
		$elements[] = new Dropdown("Player", $players);
		$elements[] = new Input("Message");
		parent::__construct("Message Form", $elements);
	}

	/**
	 * @param Player $player
	 *
	 * @return null|Form
	 */
	public function onSubmit(Player $player) : ?Form {
		Server::getInstance()->dispatchCommand(new ConsoleCommandSender(), "tell " . $this->getElement(0)->getValue() . " " . $this->getElement(1)->getValue());
		return null;
	}
}