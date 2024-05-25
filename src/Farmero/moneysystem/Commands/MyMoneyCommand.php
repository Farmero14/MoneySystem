<?php

declare(strict_types=1);

namespace Farmero\moneysystem\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use Farmero\moneysystem\MoneySystem;

class MyMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("mymoney", "Check your own money balance", "/mymoney");
        $this->setPermission("moneysystem.cmd.mymoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used by players.");
            return false;
        }

        $moneyManager = MoneySystem::getInstance()->getMoneyManager();
        $money = $moneyManager->getMoney($sender);

        $sender->sendMessage("Your current money balance: $money");

        return true;
    }
}