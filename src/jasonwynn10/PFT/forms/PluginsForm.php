<?php
declare(strict_types=1);

namespace jasonwynn10\PFT\forms;

use pocketmine\form\CustomForm;
use pocketmine\form\element\Dropdown;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class PluginsForm extends CustomForm {
	public function __construct() {
		$list = [];
		foreach(Server::getInstance()->getPluginManager()->getPlugins() as $plugin) {
			if($plugin->isEnabled()) {
				$list[] = TextFormat::GREEN . $plugin->getDescription()->getFullName();
			}
		}
		$elements[] = new Dropdown("Enabled Plugins", $list);
		$list       = [];
		foreach(Server::getInstance()->getPluginManager()->getPlugins() as $plugin) {
			if(!$plugin->isEnabled()) {
				$list[] = TextFormat::GREEN . $plugin->getDescription()->getFullName();
			}
		}
		$elements[] = new Dropdown("Disabled Plugins", $list);
		parent::__construct("Plugin List Form", $elements);
	}
}