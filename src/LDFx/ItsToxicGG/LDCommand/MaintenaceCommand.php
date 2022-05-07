<?php

namespace LDFx\ItsToxicGG\LDCommand;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;

use LDFx\ItsToxicGG\LDFx;

class MaintenaceCommand extends Command implements PluginOwned{
    
    private $plugin;

    public function __construct(LDFx $plugin){
        $this->plugin = $plugin;
        
        parent::__construct("maintenace", "§r§fEnable Maintenace Or Disable using a ui/form, Plugin By ItsToxicGG", "§cUse: /maintenace", ["maintenace"]);
        $this->setPermission("maintenace.fx");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(count($args) == 0){
            if($sender instanceof Player) {
                $this->plugin->MaintenaceForm($sender);
            } else {
                $sender->sendMessage("Use this command in-game");
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
