<?php

declare(strict_types=1);

namespace fernanACM\NickUI\Utils;

use pocketmine\player\Player;
use pocketmine\Server;

use pocketmine\world\Position;
use ReflectionClass;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;

class PluginUtils {

	public static function PlaySound(Player $player, string $sound, $volume = 1, $pitch = 1) {
		$packet = new PlaySoundPacket();
		$packet->x = $player->getPosition()->getX();
		$packet->y = $player->getPosition()->getY();
		$packet->z = $player->getPosition()->getZ();
		$packet->soundName = $sound;
		$packet->volume = 1;
		$packet->pitch = 1;
		$player->getNetworkSession()->sendDataPacket($packet);
	}
}
