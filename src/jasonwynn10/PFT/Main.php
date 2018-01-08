<?php
declare(strict_types=1);
namespace jasonwynn10\PFT;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {
	/** @var Main $instance */
	private static $instance;
	/**
	 * @return Main
	 */
	public static function getInstance() : self {
		return self::$instance;
	}
	public function onLoad() : void {
		self::$instance = $this;
	}
	public function onEnable() : void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
}