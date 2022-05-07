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
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        if (!$sender->hasPermission("maintenancemodecmd.fx")){
            $sender->sendMessage("§cYou don't have permissions to use this command");
            return true;
        }
        if (!isset($args[0])){
            $sender->sendMessage("§cUsage: §a/mm on | off");
            return true;
        }
        switch($command->getName()){
            case "maintenace":
                switch (strtolower($args[0])){
                    case "on":
                        $this->plugin->config->set("MM_Active", true);
                        $this->plugin->config->save();
                        $sender->sendMessage("§aThe Server is now on Maintenace");
                    break;
                    case "off":
                        $this->plugin->config->set("MM_Active", false);
                        $this->plugin->config->save();
                        $sender->sendMessage("§aMaintenace is off now");
                    break;
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
