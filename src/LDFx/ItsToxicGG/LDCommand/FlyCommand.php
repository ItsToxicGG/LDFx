<?php

namespace LDFx\ItsToxicGG\LDCommand;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;

use LDFx\ItsToxicGG\LDForm\Form;

class FlyCommand extends Command implements PluginOwned{
    
    private $plugin;
    public $author = 'ItsToxicGG';

    public function __construct(Form $plugin){
        $this->plugin = $plugin;
        
        parent::__construct("fly", "§r§fYour Fly Settings, Plugin By $author", "§cUse: /fly", ["flyui"]);
        $this->setPermission("fly.fx");
        $this->setAliases(["flyui"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(count($args) == 0){
            if($sender instanceof Player) {
                $this->plugin->FlyForm($sender);
            } else {
                $sender->sendMessage("Use this command in-game");
            }
        }
        return true;
    }
    
    public function getPlugin(): Plugin{
        return $this->plugin;
    }

    public function getOwningPlugin(): Loader{
        return $this->plugin;
    }
}