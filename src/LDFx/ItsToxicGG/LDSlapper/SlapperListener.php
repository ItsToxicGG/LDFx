<?php

namespace LDFx\ItsToxicGG\LDSlapper;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector2;
use pocketmine\network\mcpe\protocol\MoveActorAbsolutePacket;
use pocketmine\network\mcpe\protocol\MovePlayerPacket;
use pocketmine\player\Player;
use slapper\entities\SlapperEntity;
use slapper\entities\SlapperHuman;
use LDFx\ItsToxicGG\LDFx;

class SlapperListener implements Listener {
  
    public function __construct(private Main $plugin){
        //NOOP
    }
    public function onMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        $maxDistance = $this->plugin->getConfig()->get("max-distance");

            if ($event->getFrom()->distance($event->getTo()) < 0.1) {
                return;
            }
            foreach ($player->getWorld()->getNearbyEntities($player->getBoundingBox()->expandedCopy($maxDistance, $maxDistance, $maxDistance), $player) as $entity) {
                if (($entity instanceof SlapperHuman) or $entity instanceof SlapperEntity) {
                    $angle = atan2($player->getLocation()->z - $entity->getLocation()->z, $player->getLocation()->x - $entity->getLocation()->x);
                    $yaw = (($angle * 180) / M_PI) - 90;
                    $angle = atan2((new Vector2($entity->getLocation()->x, $entity->getLocation()->z))->distance(new Vector2($player->getLocation()->x, $player->getLocation()->z)), $player->getLocation()->y - $entity->getLocation()->y);
                    $pitch = (($angle * 180) / M_PI) - 90;

                    if ($entity instanceof SlapperHuman) {
                        $pk = new MovePlayerPacket();
                        $pk->actorRuntimeId = $entity->getId();
                        $pk->position = $entity->getLocation()->add(0, $entity->getEyeHeight(), 0);
                        $pk->yaw = $yaw;
                        $pk->pitch = $pitch;
                        $pk->headYaw = $yaw;
                        $pk->onGround = $entity->onGround;
                        $player->getNetworkSession()->sendDataPacket($pk);
                    } elseif ($entity instanceof SlapperEntity) {
                        $pk = new MoveActorAbsolutePacket();
                        $pk->actorRuntimeId = $entity->getId();
                        $pk->position = $entity->getLocation()->asVector3();
                        $pk->pitch = $pitch;
                        $pk->yaw = $yaw;
                        $pk->headYaw = $yaw;
                        $player->getNetworkSession()->sendDataPacket($pk);
                }
            }
        }
    }

}
