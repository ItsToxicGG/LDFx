<?php

namespace LDFx\ItsToxicGG\LDCommand;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;

use LDFx\ItsToxicGG\LDFx;

class PingCommand extends Command implements PluginOwned{
    
    private $plugin;

    public function __construct(LDFx $plugin){
        $this->plugin = $plugin;
        
        parent::__construct("ping", "§r§fGet Your Ping With LDFx, By ItsToxicGG", "§cUse: /ping", ["ping"]);
        $this->setAliases(["pg"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(count($args) == 0){
            if($sender instanceof Player) 
		if ($this->getServer()->getPlayer($args[0])) {
		     $player = $this->getServer()->getPlayer($args[0]);
		     $this->plugin->sendPing($sender, $player->getPing());
		     return true;
		} else {
		     $sender->sendMessage(TextFormat::RED . "Player not found");
		}
	} else {
		if ($sender instanceof Player) {
		     $this->sendPing($sender, $sender->getPing());
		     return true;
		} else {
		     $sender->sendMessage(TextFormat::RED . "Please enter a player name");
		}
	}
	break;
      }
      return false;
    }
    
    public function getPlugin(): Plugin{
        return $this->plugin;
    }

    public function getOwningPlugin(): LDFx{
        return $this->plugin;
    }
}
