<?php

namespace LDFx\ItsToxicGG\LDCommand;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use LDFx\ItsToxicGG\LDForm\FriendsForm;

class FriendCommand extends Command{
    
    public $plugin;

    public function __construct(FriendsForm $plugin)
    {
        $this->plugin = $plugin;
        
        parent::__construct("friend", "§r§fOpen Up Friends Form, Plugin By ItsToxicGG", "§cUse: /friends", ["friends"]);
        $this->setAliases(["friend", "f"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
       if($sender instanceof Player){
           $this->plugin->friendform($sender);
       } else {
           $sender->sendMessage("You not a player");
       }
    }
}
