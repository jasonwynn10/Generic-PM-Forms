<?php
declare(strict_types=1);

namespace forms;

use pocketmine\form\CustomForm;
use pocketmine\form\element\Label;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Utils;

class StatusForm extends CustomForm {
	public function __construct() {
		$rUsage = Utils::getRealMemoryUsage();
		$mUsage = Utils::getMemoryUsage(true);

		$server = Server::getInstance();

		$time = microtime(true) - \pocketmine\START_TIME;

		$seconds = floor($time % 60);
		$minutes = null;
		$hours   = null;
		$days    = null;

		if($time >= 60) {
			$minutes = floor(($time % 3600) / 60);
			if($time >= 3600) {
				$hours = floor(($time % (3600 * 24)) / 3600);
				if($time >= 3600 * 24) {
					$days = floor($time / (3600 * 24));
				}
			}
		}

		$uptime = ($minutes !== null ? ($hours !== null ? ($days !== null ? "$days days " : "") . "$hours hours " : "") . "$minutes minutes " : "") . "$seconds seconds";

		$elements[] = new Label(TextFormat::GOLD . "Uptime: " . TextFormat::RED . $uptime);

		$tpsColor = TextFormat::GREEN;
		if($server->getTicksPerSecond() < 17) {
			$tpsColor = TextFormat::GOLD;
		} elseif($server->getTicksPerSecond() < 12) {
			$tpsColor = TextFormat::RED;
		}

		$elements[] = new Label(TextFormat::GOLD . "Current TPS: {$tpsColor}{$server->getTicksPerSecond()} ({$server->getTickUsage()}%)");
		$elements[] = new Label(TextFormat::GOLD . "Average TPS: {$tpsColor}{$server->getTicksPerSecondAverage()} ({$server->getTickUsageAverage()}%)");

		$elements[] = new Label(TextFormat::GOLD . "Network upload: " . TextFormat::RED . round($server->getNetwork()->getUpload() / 1024, 2) . " kB/s");
		$elements[] = new Label(TextFormat::GOLD . "Network download: " . TextFormat::RED . round($server->getNetwork()->getDownload() / 1024, 2) . " kB/s");

		$elements[] = new Label(TextFormat::GOLD . "Thread count: " . TextFormat::RED . Utils::getThreadCount());

		$elements[] = new Label(TextFormat::GOLD . "Main thread memory: " . TextFormat::RED . number_format(round(($mUsage[0] / 1024) / 1024, 2)) . " MB.");
		$elements[] = new Label(TextFormat::GOLD . "Total memory: " . TextFormat::RED . number_format(round(($mUsage[1] / 1024) / 1024, 2)) . " MB.");
		$elements[] = new Label(TextFormat::GOLD . "Total virtual memory: " . TextFormat::RED . number_format(round(($mUsage[2] / 1024) / 1024, 2)) . " MB.");
		$elements[] = new Label(TextFormat::GOLD . "Heap memory: " . TextFormat::RED . number_format(round(($rUsage[0] / 1024) / 1024, 2)) . " MB.");
		$elements[] = new Label(TextFormat::GOLD . "Maximum memory (system): " . TextFormat::RED . number_format(round(($mUsage[2] / 1024) / 1024, 2)) . " MB.");

		if($server->getProperty("memory.global-limit") > 0) {
			$elements[] = new Label(TextFormat::GOLD . "Maximum memory (manager): " . TextFormat::RED . number_format(round($server->getProperty("memory.global-limit"), 2)) . " MB.");
		}

		foreach($server->getLevels() as $level) {
			$levelName  = $level->getFolderName() !== $level->getName() ? " (" . $level->getName() . ")" : "";
			$timeColor  = ($level->getTickRate() > 1 or $level->getTickRateTime() > 40) ? TextFormat::RED : TextFormat::YELLOW;
			$tickRate   = $level->getTickRate() > 1 ? " (tick rate " . $level->getTickRate() . ")" : "";
			$elements[] = new Label(TextFormat::GOLD . "World \"{$level->getFolderName()}\"$levelName: " . TextFormat::RED . number_format(count($level->getChunks())) . TextFormat::GREEN . " chunks, " . TextFormat::RED . number_format(count($level->getEntities())) . TextFormat::GREEN . " entities, " . TextFormat::RED . number_format(count($level->getTiles())) . TextFormat::GREEN . " tiles. " . "Time $timeColor" . round($level->getTickRateTime(), 2) . "ms" . $tickRate);
		}
		$elements = [];
		parent::__construct("Status Form", $elements);
	}
}