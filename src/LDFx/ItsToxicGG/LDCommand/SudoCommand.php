<?php

namespace LDFx\ItsToxicGG\LDCommand;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\event\Listener;

use LDFx\ItsToxicGG\LDFx;

class SocialMenuCommand extends Command implements PluginOwned, Listener{

    private $plugin;

    public function __construct(LDFx $plugin){
        $this->plugin = $plugin;
        
        parent::__construct("sudo", "§r§fChat as another player:), dont use for evil..., Plugin By ItsToxicGG", "§cUse: /sudo", ["sudo"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $usage = $this->plugin->config->get("usage");
        $notfound = $this->plugin->config->get("notfound");
        if(count($args) == 0){
           case "sudo":
             if (count($args) < 2) {
               $sender->sendMessage($prefix . $usage);
               return true;
            }
            $player = $this->getServer()->getPlayerExact(array_shift($args));
            if ($player instanceof Player) {
            $player->chat(trim(implode(" ", $args))); //$this->getServer()->dispatchCommand($player, trim(implode(" ", $args)));
        } else {
            $sender->sendMessage($notfound);
        }
      }
      return true;
    }
    
    public function getPlugin(): Plugin{
        return $this->plugin;
    }

    public function getOwningPlugin(): LDFx{
        return $this->plugin;
    }
}
