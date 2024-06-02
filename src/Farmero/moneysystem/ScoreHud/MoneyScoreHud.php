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

    public function updateScoreHudTags(Player $player): void {
        if (class_exists(ScoreHud::class)) {
            $moneyManager = MoneySystem::getInstance()->getMoneyManager();
            $balance = $moneyManager->getMoney($player);
            $formattedBalance = $moneyManager->formatMoney($balance);

            $ev = new PlayerTagsUpdateEvent(
                $player,
                [
                    new ScoreTag("moneysystem.balance", $formattedBalance),
                ]
            );
            $ev->call();
        }
    }

    public function onTagResolve(TagsResolveEvent $event): void {
        $player = $event->getPlayer();
        $tag = $event->getTag();

        $moneyManager = MoneySystem::getInstance()->getMoneyManager();
        $balance = $moneyManager->getMoney($player);
        $formattedBalance = $moneyManager->formatMoney($balance);

        match ($tag->getName()) {
            "moneysystem.balance" => $tag->setValue($formattedBalance),
            default => null,
        };
    }
}
