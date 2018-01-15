<?php
declare(strict_types=1);

namespace forms;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\form\Form;
use pocketmine\form\MenuForm;
use pocketmine\form\MenuOption;
use pocketmine\Player;
use pocketmine\Server;

class GamemodeForm extends MenuForm {
	/**
	 * GamemodeForm constructor.
	 */
	public function __construct() {
		$options = [];
		$options[] = new MenuOption("Survival");
		$options[] = new MenuOption("Creative");
		$options[] = new MenuOption("Adventure");
		$options[] = new MenuOption("Spectator");
		parent::__construct("Gamemode Selector", "Choose a gamemode from the list", $options);
	}

	/**
	 * @param Player $player
	 *
	 * @return null|Form
	 */
	public function onSubmit(Player $player) : ?Form {
		Server::getInstance()->dispatchCommand(new ConsoleCommandSender(), "gamemode ".$this->getSelectedOption()->getText()." ".$player->getName());
		return null;
	}
}