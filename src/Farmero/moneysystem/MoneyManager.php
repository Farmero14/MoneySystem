<?php

declare(strict_types=1);

namespace Farmero\moneysystem;

use pocketmine\player\Player;
use pocketmine\utils\Config;

use Farmero\moneysystem\MoneySystem;

class MoneyManager {

    private $plugin;
    private $moneyData;

    public function __construct(MoneySystem $plugin) {
        $this->plugin = $plugin;
        $this->initMoneyData();
    }

    private function initMoneyData() {
        $this->moneyData = new Config($this->plugin->getDataFolder() . "Money_Data.json", Config::JSON);
    }

    public function setMoney(Player $player, int $amount) {
        $this->moneyData->set(strtolower($player->getName()), $amount);
        $this->moneyData->save();
    }

    public function addMoney(Player $player, int $amount): void {
        $currentMoney = $this->getMoney($player);
        $newMoney = $currentMoney + $amount;
        $this->setMoney($player, $newMoney);
    }

    public function removeMoney(Player $player, int $amount) {
        $currentMoney = $this->getMoney($player);
        $newMoney = max(0, $currentMoney - $amount);
        $this->setMoney($player, $newMoney);
    }

    public function getMoney(Player $player) {
        $playerName = strtolower($player->getName());
        $moneyDataArray = $this->moneyData->getAll();
        return $moneyDataArray[$playerName] ?? 0;
    }

    public function getAllMoneyData(): array {
        return $this->moneyData->getAll();
    }
}
