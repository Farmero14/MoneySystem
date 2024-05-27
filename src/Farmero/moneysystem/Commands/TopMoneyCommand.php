<?php

declare(strict_types=1);

namespace Farmero\moneysystem\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Farmero\moneysystem\MoneySystem;

class TopMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("topmoney", "Show the top players by money balance", "/topmoney");
        $this->setPermission("moneysystem.cmd.topmoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        $moneyManager = MoneySystem::getInstance()->getMoneyManager();
        $allMoneyData = $moneyManager->getAllMoneyData();

        arsort($allMoneyData);

        $topPlayers = array_slice($allMoneyData, 0, 10, true);

        $sender->sendMessage("Top 10 players by money balance:");
        foreach ($topPlayers as $playerName => $money) {
            $sender->sendMessage("- $playerName: $money");
        }

        return true;
    }
}
