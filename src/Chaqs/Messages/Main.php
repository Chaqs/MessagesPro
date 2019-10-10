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


class Main extends PluginBase implements Listener
{

    public function onEnable(): void
    {

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function OnJoin(PlayerJoinEvent $event) {
     $player = $event->getPlayer();
     $name = $player->getName();
        if($player->hasPlayedBefore()){
         $player->sendMessage(str_replace('{name}', $name, $this->getConfig()->get("join-message-player")));
         $event->setJoinMessage(str_replace('{name}', $name, $this->getConfig()->get("join-message-broadcast")));
        }else{
        $event->setJoinMessage(str_replace('{name}', $name, $this->getConfig()->get("first-join-broadcast")));
        $player->sendMessage(str_replace('{name}', $name, $this->getConfig()->get("first-join-player")));

          }
       }

    public function OnQuit(PlayerQuitEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
        $event->setQuitMessage(str_replace('{name}', $name, $this->getConfig()->get("quit-message-broadcast")));
    }




	public function onDisable() : void{

	}
}
