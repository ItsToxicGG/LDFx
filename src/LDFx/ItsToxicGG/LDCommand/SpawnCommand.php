<?php
declare(strict_types=1);

namespace LDFx\ItsToxicGG\LDCommands;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\plugin\PluginOwned;

use LDFx\ItsToxicGG\LDFx;


class SpawnCommand extends Command implements PluginOwned {

    private $plugin;

    public function __construct(LDFx $plugin){
        $this->plugin = $plugin; 
        
        parent::__construct("spawn", 'Teleport you to the server spawn!', null, ["hub", "lobby"]);
        $this->setAliases(["hub", "lobby"]);
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if ($sender instanceof Player) {
            $sender->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
            } else {
                $sender->sendMessage("Use this command in-game");
            }
        }
    }

    public function getOwningPlugin(): LDFx{
        return $this->plugin;
    }
 }
