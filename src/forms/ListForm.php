<?php
declare(strict_types=1);

namespace forms;

use pocketmine\form\CustomForm;
use pocketmine\form\element\Dropdown;
use pocketmine\Server;

class ListForm extends CustomForm {
	/**
	 * ListForm constructor.
	 */
	public function __construct() {
		$elements = [];
		$players  = [];
		foreach(Server::getInstance()->getOnlinePlayers() as $player) {
			$players[] = $player->getName();
		}
		$elements[] = new Dropdown("Online Players", $players);
		parent::__construct("Player List Form", $elements);
	}
}