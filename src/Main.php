<?php

declare(strict_types=1);

namespace ashaibery\CreativeLimit;



use pocketmine\block\VanillaBlocks;
use pocketmine\player\GameMode;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config; 
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\TextFormat as TF;
use pocketmine\player\Player;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(TF::GREEN . "--- Creative Limit Plugin Enabled By ashaibery Dev ---");
    }
    public function onDisable(): void {
        $this->getLogger()->info(TF::RED . "--- Creative Limit Plugin Disabled ---");
    }
    public function onInteract(PlayerInteractEvent $event ): void {
        $player = $event->getPlayer();
        $blocks1 = $event->getPlayer()->getInventory()->getItemInHand()->getName();
        $blocks2 = $event->getBlock()->getName();
        $blacklist1 = [
            VanillaBlocks::ENDER_CHEST()->getName(),
            VanillaBlocks::CHEST()->getName(),
            VanillaBlocks::FURNACE()->getName(),
            VanillaBlocks::Anvil()->getName(),
            VanillaBlocks::ITEM_FRAME()->getName(),
            VanillaBlocks::SHULKER_BOX()->getName(),
            VanillaBlocks::GOLD()->getName(),
            VanillaBlocks::GOLD_ORE()->getname(),
            VanillaBlocks::TRAPPED_CHEST()->getName(),
            VanillaBlocks::ENCHANTING_TABLE()->getName(),
            VanillaBlocks::IRON()->getName(),
            VanillaBlocks::IRON_ORE()->getName(),
            VanillaBlocks::DIAMOND()->getName(),
            VanillaBlocks::DIAMOND_ORE()->getName(),
            VanillaBlocks::EMERALD()->getName(),
            VanillaBlocks::EMERALD_ORE()->getName()
        ];
        $blacklist2 = [
            VanillaBlocks::CHEST()->getName(),
            VanillaBlocks::TRAPPED_CHEST()->getName(),
            VanillaBlocks::SHULKER_BOX()->getName(),
            ];
        if ($player->isCreative()) {
            if (in_array($blocks1, $blacklist1)) {
            	if (!$player->hasPermission("no.limit")) {
                       $event->cancel();
                } else {
                return;
            }  
            }
            else if (in_array($blocks2, $blacklist2)) {
                $event->cancel();
            }
        }
    }

    public function onGameModeChange(PlayerGameModeChangeEvent $event): void {
        $player = $event->getPlayer();
        $newGM = $event->getNewGamemode();
        if ($newGM === GameMode::SURVIVAL) {
        	if (!$player->hasPermission("no.limit")) {
               $player->getInventory()->clearAll();
               $player->getArmorInventory()->clearAll();
            } else {
                return;
            } 
        }
    }

    public function onDropItem(PlayerDropItemEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->isCreative()){
        	if (!$player->hasPermission("no.limit")) {
            $event->cancel();
            } else {
                return;
            }  
        }
    }
        
    public function onPlayerDeath(PlayerDeathEvent $event): void {
        $player = $event->getPlayer();
        if ($player->isCreative()) {
        	if (!$player->hasPermission("no.limit")) {
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
            } else {
                return;
            }  
        }
    }

}
