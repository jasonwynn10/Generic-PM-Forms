<?php
declare(strict_types=1);

namespace jasonwynn10\PFT\forms;

use pocketmine\form\CustomForm;
use pocketmine\form\element\Dropdown;
use pocketmine\form\element\Input;
use pocketmine\form\element\Toggle;
use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\Server;

class WhiteListForm extends CustomForm {
	public function __construct() {
		$elements   = [];
		$elements[] = new Toggle("Enable/Disable Whitelist");
		$elements[] = new Dropdown("Player List", Server::getInstance()->getWhitelisted()->getAll(true));
		$elements[] = new Input("Add Player");
		$elements[] = new Toggle("Reload Whitelist");
		parent::__construct("Whitelist Form", $elements);
	}

	public function onSubmit(Player $player) : ?Form {
		$whitelist = Server::getInstance()->getWhitelisted();
		if($this->getElement(3)->getValue()) {
			$whitelist->reload();
		}
		if(!empty($this->getElement(2)->getValue())) {
			Server::getInstance()->getOfflinePlayer($this->getElement(2)->getValue())->setWhitelisted(true);
		}
		if($this->getElement(0)->getValue()) {
			Server::getInstance()->setConfigBool("white-list", true);
		} else {
			Server::getInstance()->setConfigBool("white-list", false);
		}
		return null;
	}
}