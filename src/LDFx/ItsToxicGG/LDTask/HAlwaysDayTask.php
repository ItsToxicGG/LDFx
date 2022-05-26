<?php

declare(strict_types=1);

namespace LDFx\ItsToxicGG\LDTask;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\world\World;

class HAlwaysDayTask extends Task
{
    public function onRun(): void
    {
        foreach(Server::getInstance()->getWorldManager()->getWorlds() as $worlds) {
            $worlds->setTime(World::TIME_DAY);
        }
    }

}
