<?php

namespace LDFx\ItsToxicGG\LDEvent;

use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\EnderPearl;
use pocketmine\event\Listener;
use LDFx\ItsToxicGG\LDFx;
use function str_replace;
use function time;

class EventListener implements Listener {
  
  public $plugin;
  public $message;
  public $cooldown;
	
  public function __construct(LDFx $plugin){
          $this->plugin = $plugin;
  }

	public function onItemUse(PlayerItemUseEvent $event) : void {
		if($event->getItem() instanceof EnderPearl){
			$player = $event->getPlayer();
			$cd = $this->plugin->cooldowns[$player->getId()] ?? null;
			if($cd !== null && time() - $cd < $this->cooldown){
				$event->cancel();
				$player->sendMessage(str_replace('{cooldown}', $this->plugin->cooldown - (time() - $cd), $this->plugin->message));
			} else {
				$this->plugin->cooldowns[$player->getId()] = time();
			}
		}
	}

	public function onQuit(PlayerQuitEvent $event) : void {
		unset($this->plugin->cooldowns[$event->getPlayer()->getId()]);
	}
}
