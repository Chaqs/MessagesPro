<?php

declare(strict_types=1);

namespace Chaqs\Messages;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\utils\TextFormat;
use pocketmine\event\entity\EntityDamageEvent;


class Main extends PluginBase implements Listener
{

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function OnJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $name = $player->getName();
        if ($player->hasPlayedBefore()) {
            $player->sendMessage(str_replace('{name}', $name, $this->getConfig()->get("join-message-player")));
            $event->setJoinMessage(str_replace('{name}', $name, $this->getConfig()->get("join-message-broadcast")));
        } else {
            $event->setJoinMessage(str_replace('{name}', $name, $this->getConfig()->get("first-join-broadcast")));
            $player->sendMessage(str_replace('{name}', $name, $this->getConfig()->get("first-join-player")));

        }
    }

    public function OnQuit(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer();
        $name = $player->getName();
        $event->setQuitMessage(str_replace('{name}', $name, $this->getConfig()->get("quit-message-broadcast")));
    }

    public function onDeath(PlayerDeathEvent $event)
    {
        $player = $event->getPlayer();
        $name = $player->getName();
        $cause = $player->getLastDamageCause()->getCause();
        if ($cause === EntityDamageEvent::CAUSE_SUFFOCATION) {
            $event->setDeathMessage(str_replace('{name}', $name, $this->getConfig()->get("suffocation-death")));
        } elseif ($cause === EntityDamageEvent::CAUSE_DROWNING) {
            $event->setDeathMessage(str_replace('{name}', $name, $this->getConfig()->get("drown-death")));
        } elseif ($cause === EntityDamageEvent::CAUSE_FALL) {
            $event->setDeathMessage(str_replace('{name}', $name, $this->getConfig()->get("fall-damage-death")));
        } elseif ($cause === EntityDamageEvent::CAUSE_FIRE) {
            $event->setDeathMessage(str_replace('{name}', $name, $this->getConfig()->get("fire-damage-death")));
        } elseif ($cause === EntityDamageEvent::CAUSE_LAVA) {
            $event->setDeathMessage(str_replace('{name}', $name, $this->getConfig()->get("lava-death")));
        } elseif ($cause === EntityDamageEvent::CAUSE_BLOCK_EXPLOSION) {
            $event->setDeathMessage(str_replace('{name}', $name, $this->getConfig()->get("explosion-death")));
        } else {
            $event->setDeathMessage(str_replace('{name}', $name, $this->getConfig()->get("other-death")));

        }
    }
}

