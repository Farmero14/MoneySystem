<?php

declare(strict_types=1);

namespace Farmero\moneysystem\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Farmero\moneysystem\MoneySystem;

class SeeMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("seemoney", "See a player's money balance", "/seemoney <player>");
        $this->setPermission("moneysystem.cmd.seemoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) !== 1) {
            $sender->sendMessage("Usage: /seemoney <player>");
            return false;
        }

        $targetPlayerName = strtolower($args[0]);
        $moneyManager = MoneySystem::getInstance()->getMoneyManager();
        $moneyData = $moneyManager->getAllMoneyData();

        if (isset($moneyData[$targetPlayerName])) {
            $balance = $moneyData[$targetPlayerName];
            $sender->sendMessage("Player $targetPlayerName has a balance of $balance");
        } else {
            $sender->sendMessage("Player $targetPlayerName not found or has no balance");
        }

        return true;
    }
}