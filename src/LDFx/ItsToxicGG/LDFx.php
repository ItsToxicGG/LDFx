<?php

namespace LDFx\ItsToxicGG;

// LDFX
use LDFx\ItsToxicGG\LDCommand\SettingsCommand;
use LDFx\ItsToxicGG\LDCommand\FlyCommand;
use LDFx\ItsToxicGG\LDCommand\NickColorCommand;
use LDFx\ItsToxicGG\LDCommand\GUICommand;
use LDFx\ItsToxicGG\LDCommand\SocialMenuCommand;
use LDFx\ItsToxicGG\LDTask\HPingTask;
use LDFx\ItsToxicGG\LDUtils\PluginUtils;
// POCKETMINE
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\entity\Entity;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\entity\projectile\Arrow;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;
use pocketmine\event\EventPriority;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\entity\projectile\EnderPearl;
use pocketmine\entity\Living;
use pocketmine\item\ItemFactory;
use pocketmine\math\Vector3;
use pocketmine\world\Position;
use pocketmine\world\World;
use pocketmine\utils\TextFormat as C;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\utils\Config;
// FORM
use Vecnavium\FormsUI\CustomForm;
use Vecnavium\FormsUI\SimpleForm;

class LDFx extends PluginBase implements Listener
{
	
  private $config;
 
  public function onEnable(): void{
      $this->getLogger()->info("§aEnabled LDFx");
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      $this->BetterPearl();
      @mkdir($this->getDataFolder());
      $this->saveDefaultConfig();
      $this->config = $this->getConfig();  
      $this->getScheduler()->scheduleRepeatingTask(new HPingTask($this), 20);
      $this->getServer()->getCommandMap()->register("settings", new SettingsCommand($this));
      $this->getServer()->getCommandMap()->register("fly", new FlyCommand($this));
      $this->getServer()->getCommandMap()->register("nickcolor", new NickColorCommand($this));
      $this->getServer()->getCommandMap()->register("games", new GUICommand($this));
      $this->getServer()->getCommandMap()->register("socialmenu", new SocialMenuCommand($this));
  }
  
  public function onDiable(): void{
      $this->getLogger()->info("§cDisabled LDFx");
  }
  
  public function SettingsForm($player){
       $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            switch($data){
                case 0:
                    $this->FlyForm($player);
                    $player->sendMessage("§aYou Have Left the Settings to FlyForm!");
                break;
            
                case 1:
	            $this->NickColorForm($player);
	            $player->sendMessage("§aYou Have Left the Settings to NickColorForm!");
                break;
			    
		case 2:
	            $player->sendMessage("§aYou Have Left The Form!");
	        break;
            }
       });
       $form->setTitle("§bSettings");
       $form->setContent("§fPick THe Setting!");
       $form->addButton("§aFly§cSettings");
       $form->addButton("§bNicknameColors");
       $form->addButton("§cEXIT");
       $form->sendToPlayer($player);
       return $form;
  }
  
  public function FlyForm($player){
      $form = new CustomForm(function(Player $player, $data){
          if($data === null){
              return true;
          }
          switch($data){
              case true:
                  $player->setFlying(true);
                  $player->setAllowFlight(true);
                  $player->sendMessage("§aFly Is Active");
              break;
            
              case false:
                  $player->setFlying(false);
                  $player->setAllowFlight(true);
                  $player->sendMessage("§cFly Is Disabled");
              break;
           }
      });
      $form->setTitle("§aFly§cSettings");
      $form->addLabel("§fChoose if you want fly to be off or on");
      $form->addToggle("§fFly", true);
      $form->sendToPlayer($player);
      return $form;
  }
  
  public function NickColorForm(Player $player){
		  $form = new SimpleForm(function (Player $player, $data = null){
			    if($data === null){
		          return true;
	        }
		      switch($data){
				      case 0:
					        $player->setDisplayName("§f" . $player->getName() . "§f");
					        $player->setNameTag("§f" . $player->getName() . "§f");
					        $player->sendMessage("§anickname color has been changed to §fWhite!");
				      break;

				      case 1:
					        $player->setDisplayName("§c" . $player->getName() . "§f");
					        $player->setNameTag("§c" . $player->getName() . "§f");
					        $player->sendMessage("§aYour nickname color has been changed to §cRed!");
				      break;

				      case 2:
					        $player->setDisplayName("§b" . $player->getName() . "§f");
					        $player->setNameTag("§b" . $player->getName() . "§f");
					        $player->sendMessage("§aYour nickname color has been changed to §bBlue!");
				      break;

				      case 3:
					        $player->setDisplayName("§e" . $player->getName() . "§f");
					        $player->setNameTag("§e" . $player->getName() . "§f");
					        $player->sendMessage("§aYour nickname color has been changed to §eYellow!");
				      break;

				      case 4:
					        $player->setDisplayName("§6" . $player->getName() . "§f");
					        $player->setNameTag("§6" . $player->getName() . "§f");
					        $player->sendMessage("§aYour nickname color has been changed to §6Orange!");
				      break;

				      case 5:
					        $player->setDisplayName("§d" . $player->getName() . "§f");
					         $player->setNameTag("§d" . $player->getName() . "§f");
					         $player->sendMessage("§aYour nickname color has been changed to §dPurple!");
				      break;
           
              case 6:
					         $player->setDisplayName("§0" . $player->getName() . "§f");
					         $player->setNameTag("§0" . $player->getName() . "§f");
					         $player->sendMessage("§aYour nickname color has been changed to §0Black!");
              break;
			      }
		     return true;
      });
		  $form->setTitle("§bNicknameColors");
		  $form->setContent("§fSelect your color you prefer to your nickname!");
		  $form->addButton("White");
		  $form->addButton("§cRed");
		  $form->addButton("§bBlue");
		  $form->addButton("§eYellow");
		  $form->addButton("§6Orange");
		  $form->addButton("§dPurple");
                  $form->addButton("§0Black");
		  $form->sendToPlayer($player);
		  return $form;
  }
	
  public function GUI($player){
       $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            switch($data){
                case 0:
                    $this->getServer()->getCommandMap()->dispatch($player, $this->getConfig()->get("GameUi-1"));
                break;
            
                case 1:
                    $this->getServer()->getCommandMap()->dispatch($player, $this->getConfig()->get("GameUi-2"));
                break;
			    
		case 2:
                    $this->getServer()->getCommandMap()->dispatch($player, $this->getConfig()->get("GameUi-3"));
	        break;
			    
		case 3:
		    $player->sendMessage("§aClosed Teleporter Form!");
	        break;
            }
       });
       $form->setTitle("§bSettings");
       $form->setContent("§fChoose the minigame you wanna play!");
       $form->addButton("§9The§cBridge");
       $form->addButton("§aBed§eWars");
       $form->addButton("§aSky§7Wars");
       $form->addButton("§cEXIT");
       $form->sendToPlayer($player);
       return $form;
  }
	
  public function SocialMenuForm($player){
       $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            switch($data){
                case 0:
                    $this->getServer()->getCommandMap()->dispatch($player, "party");
                break;
            
                case 1:
                    $this->getServer()->getCommandMap()->dispatch($player, "settings");
                break;
			        
		case 2:
		    $player->sendMessage("§aClosed Teleporter Form!");
	        break;
            }
       });
       $form->setTitle("§dSocial Menu");
       $form->setContent("§fChoose the minigame you wanna play!");
       $form->addButton("§9Parties");
       $form->addButton("§aSettings");
       $form->addButton("§cEXIT");
       $form->sendToPlayer($player);
       return $form;
  }
  
  private function FlyMWCheck(Entity $entity) : bool{
        if(!$entity instanceof Player) return false;
	if($this->getConfig()->get("FLY-MW") === "on"){
		if(!in_array($entity->getWorld()->getDisplayName(), $this->getConfig()->get("Worlds"))){
			$entity->sendMessage("This world does not allow flight!");
			if(!$entity->isCreative()){
				$entity->setFlying(false);
				$entity->setAllowFlight(false);
			}
			return false;
		}
	}elseif($this->getConfig()->get("FLY-MW") === "off") return true;
	return true;
  }

  public function onJoin(PlayerJoinEvent $event) : void{
	$player = $event->getPlayer();
	if($this->getConfig()->get("JFlyReset") === true){
		if($player->isCreative()) return;
		$player->setAllowFlight(false);
		$player->sendMessage($this->getConfig()->get("FDMessage"));
	}
	  
        $player = $event->getPlayer();
        $player->getInventory()->clearAll();
        $item1 = ItemFactory::getInstance()->get(450, 0, 1);
        $item2 = ItemFactory::getInstance()->get(345, 0, 1);
        $item3 = ItemFactory::getInstance()->get(421, 0, 1);
        $item1->setCustomName($this->getConfig()->get("item1-name"));
        $item2->setCustomName($this->getConfig()->get("item2-name"));
        $item3->setCustomName($this->getConfig()->get("item3-name"));
        $player->getInventory()->setItem(0, $item1);
        $player->getInventory()->setItem(4, $item2);
        $player->getInventory()->setItem(8, $item3);
  }
	
  public function onClick(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $itn = $player->getInventory()->getItemInHand()->getCustomName();
        if($itn == $this->getConfig()->get("item1-name")){
            $this->getServer()->getCommandMap()->dispatch($player, $this->getConfig()->get("item1-cmd"));
        }
        if($itn == $this->getConfig()->get("item2-name")){
            $this->getServer()->getCommandMap()->dispatch($player, $this->getConfig()->get("item2-cmd"));
        }
        if($itn == $this->getConfig()->get("item3-name")){
            $this->getServer()->getCommandMap()->dispatch($player, $this->getConfig()->get("item3-cmd"));
        }
 }

 public function onInventory(InventoryTransactionEvent $event){
      $event->cancel();
 }

  public function onLevelChange(EntityTeleportEvent $event) : void{
	$entity = $event->getEntity();
	if($entity instanceof Player) $this->FlyMWCheck($entity);
  }
	
  public function onChange(EntityTeleportEvent $event) : void{
       	$entity = $event->getEntity();
	if($entity instanceof Player) $this->clear($entity);
  }
	
  public function clear($player){
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
  }
	
  public function onProjectileHit(ProjectileHitEvent $event){
	$player = $event->getEntity()->getOwningEntity();
	if(!$event->getEntity() instanceof Arrow) return;
	if($player instanceof Player && $event instanceof ProjectileHitEntityEvent) {
		$target = $event->getEntityHit();
		if($target instanceof Player) {
			if($this->config->get("enable-sound", true)) {
				$pk = new PlaySoundPacket();
				$pk->x = $player->getPosition()->getX();
				$pk->y = $player->getPosition()->getY();
				$pk->z = $player->getPosition()->getZ();
				$pk->volume = $this->config->get("sound-volume");
				$pk->pitch = $this->config->get("sound-pitch");
				$pk->soundName = $this->config->get("sound-name");
				$player->getNetworkSession()->sendDataPacket($pk);
			}
			if($this->config->get("enable-message", true)) {
			    $player->sendMessage(str_replace(["{hp}", "{damage}", "{name}", "{display}"], [$target->getHealth(), $event->getEntity()->getResultDamage(), $target->getName(), $target->getDisplayName()], $this->config->get("hit-message")));
			}
			if($this->config->get("enable-popup", true)) {
			    $player->sendPopup(str_replace(["{hp}", "{damage}", "{name}", "{display}"], [$target->getHealth(), $event->getEntity()->getResultDamage(), $target->getName(), $target->getDisplayName()], $this->config->get("hit-popup")));
			}
			if($this->config->get("enable-tip", true)) {
			    $player->sendTip(str_replace(["{hp}", "{damage}", "{name}", "{display}"], [$target->getHealth(), $event->getEntity()->getResultDamage(), $target->getName(), $target->getDisplayName()], $this->config->get("hit-tip")));
			}
		}
	}
  }	
	
  public function BetterPearl(){
       $this->getServer()->getPluginManager()->registerEvent(ProjectileHitEvent::class, static function (ProjectileHitEvent $event) : void{
           $projectile = $event->getEntity();
           $entity = $projectile->getOwningEntity();
           if ($projectile instanceof EnderPearl and $entity instanceof Player) {
               $vector = $event->getRayTraceResult()->getHitVector();
               (function() use($vector) : void{ //HACK : Closure bind hack to access inaccessible members
                   $this->setPosition($vector);
               })->call($entity);
               $location = $entity->getLocation();
               $entity->getNetworkSession()->syncMovement($location, $location->yaw, $location->pitch);
               $projectile->setOwningEntity(null);
           }
       }, EventPriority::NORMAL, $this);
   }
}        
 
