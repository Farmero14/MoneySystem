<?php

declare(strict_types=1);

namespace Farmero\moneysystem\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use Farmero\moneysystem\MoneySystem;

class AddMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("addmoney", "Add money to a player's account", "/addmoney <player> <amount>");
        $this->setPermission("moneysystem.cmd.addmoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) !== 2) {
            $sender->sendMessage("Usage: /addmoney <player> <amount>");
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
        $moneyManager->addMoney($player, $amount);
        $sender->sendMessage("Added $amount to " . $player->getName() . "'s account.");

        return true;
    }
}