<?php

declare(strict_types=1);

namespace Farmero\moneysystem\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Farmero\moneysystem\MoneySystem;

class SetMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("setmoney", "Set money for a player's account", "/setmoney <player> <amount>");
        $this->setPermission("moneysystem.cmd.setmoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) !== 2) {
            $sender->sendMessage("Usage: /setmoney <player> <amount>");
            return false;
        }

        $player = MoneySystem::getInstance()->getServer()->getPlayerExact($args[0]);
        if ($player === null) {
            $sender->sendMessage("Player not found.");
            return false;
        }

        $amount = (int)$args[1];
        if ($amount < 0) {
            $sender->sendMessage("Amount cannot be negative.");
            return false;
        }

        $moneyManager = MoneySystem::getInstance()->getMoneyManager();
        $moneyManager->setMoney($player, $amount);
        $formattedAmount = $moneyManager->formatMoney($amount);
        $sender->sendMessage("Set $formattedAmount for " . $player->getName() . "'s account.");

        return true;
    }
}
