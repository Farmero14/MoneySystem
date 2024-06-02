<?php

declare(strict_types=1);

namespace Farmero\moneysystem\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use Farmero\moneysystem\MoneySystem;

class PayMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("paymoney", "Pay money to another player", "/paymoney <player> <amount>");
        $this->setPermission("moneysystem.cmd.paymoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) !== 2) {
            $sender->sendMessage("Usage: /paymoney <player> <amount>");
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
        $currentMoney = $moneyManager->getMoney($sender);

        if ($amount > $currentMoney) {
            $sender->sendMessage("You do not have enough money.");
            return false;
        }

        $moneyManager->removeMoney($sender, $amount);
        $moneyManager->addMoney($player, $amount);
        $formattedAmount = $moneyManager->formatMoney($amount);
        $sender->sendMessage("Paid $formattedAmount to " . $player->getName());

        return true;
    }
}
