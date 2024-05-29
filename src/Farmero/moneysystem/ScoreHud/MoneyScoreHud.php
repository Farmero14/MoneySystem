<?php

declare(strict_types=1);

namespace Farmero\moneysystem\ScoreHud;

use pocketmine\player\Player;

use Ifera\ScoreHud\event\PlayerTagsUpdateEvent;
use Ifera\ScoreHud\scoreboard\ScoreTag;
use Ifera\ScoreHud\ScoreHud;
use Ifera\ScoreHud\event\TagsResolveEvent;

use Farmero\moneysystem\MoneySystem;

class MoneyScoreHud {

    private $plugin;

    public function __construct(MoneySystem $plugin) {
        $this->plugin = $plugin;
    }

    public function updateScoreHudTags(Player $player): void {
        if (class_exists(ScoreHud::class)) {
            $moneyManager = $this->plugin->getMoneyManager();
            $balance = $moneyManager->getMoney($player);

            $ev = new PlayerTagsUpdateEvent(
                $player,
                [
                    new ScoreTag("moneysystem.balance", (string)$balance),
                ]
            );
            $ev->call();
        }
    }

    public function onTagResolve(TagsResolveEvent $event): void {
        $player = $event->getPlayer();
        $tag = $event->getTag();

        $moneyManager = $this->plugin->getMoneyManager();
        $balance = $moneyManager->getMoney($player);

        match ($tag->getName()) {
            "moneysystem.balance" => $tag->setValue((string)$balance),
            default => null,
        };
    }
}