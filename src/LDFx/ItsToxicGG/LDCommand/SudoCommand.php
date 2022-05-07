<?php

namespace LDFx\ItsToxicGG\LDCommand;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;

use LDFx\ItsToxicGG\LDFx;

class SudoCommand extends Command implements Listener, PluginOwned{

    private $plugin;
    public $config;

    public function __construct(LDFx $plugin){
      $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args) : bool {
      $prefix = TextFormat::GREEN . "[" . TextFormat::YELLOW . "LDFx" . TextFormat::GREEN . "] ";
      $usage = $this->plugin->config->get("usage");
      $notfound = $this->plugin->config->get("notfound");
      if (count($args) < 2) {
        $sender->sendMessage($prefix . $usage);
        return true;
      }
      $player = $this->getServer()->getPlayerExact(array_shift($args));
      if ($player instanceof Player) {
           $player->chat(trim(implode(" ", $args))); //$this->getServer()->dispatchCommand($player, trim(implode(" ", $args)));
      } else {
           $sender->sendMessage($prefix. $notfound);
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
