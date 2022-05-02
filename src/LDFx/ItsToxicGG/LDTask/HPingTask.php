<?php

namespace ItsToxicGG\LDTask;

use LDFx\ItsToxicGG\LDFx;
use pocketmine\scheduler\Task;

class HPingTask extends Task {

    private LDFx $plugin;

    public function __construct(LDFx $LDFx) {
        $this->plugin = $LDFx;
    }

    public function onRun() : void {
        if ($this->plugin->getServer()->getTicksPerSecondAverage() >= $this->plugin->getConfig()->get("tps-check")) {
            foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
                if ($player->getNetworkSession()->getPing() >= $this->plugin->getConfig()->get("ping-kick")) {
                    $player->kick($this->plugin->getConfig()->get("kick-message"));
                }
            }
        }
    }
}
