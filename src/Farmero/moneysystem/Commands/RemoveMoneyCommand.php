<?php

declare(strict_types=1);

namespace Farmero\moneysystem\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use Farmero\moneysystem\MoneySystem;

class RemoveMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("removemoney", "Remove money from a player's account", "/removemoney <player> <amount>");
        $this->setPermission("moneysystem.cmd.removemoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) !== 2) {
            $sender->sendMessage("Usage: /removemoney <player> <amount>");
            return false;
        }

        $player = MoneySystem::getInstance()->getServer()->getPlayerExact($args[0]);
        if ($player === null) {
            $sender->sendMessage("Player not found.");
            return false;
        }

        $amount = (int)$args[1];
        if ($amount <= 0) {
            $sender->sendMessage("Amount must be a positive integer.");
            return false;
        }

        $moneyManager = MoneySystem::getInstance()->getMoneyManager();
        $currentMoney = $moneyManager->getMoney($player);

        if ($amount > $currentMoney) {
            $sender->sendMessage("Player does not have enough money.");
            return false;
        }

        $moneyManager->removeMoney($player, $amount);
        $formattedAmount = $moneyManager->formatMoney($amount);
        $sender->sendMessage("Removed $formattedAmount from " . $player->getName() . "'s account.");

        return true;
    }
}
