<?php

declare(strict_types=1);

namespace Farmero\moneysystem;

use pocketmine\plugin\PluginBase;

use Farmero\moneysystem\MoneyManager;

use Farmero\moneysystem\Commands\SetMoneyCommand;
use Farmero\moneysystem\Commands\AddMoneyCommand;
use Farmero\moneysystem\Commands\RemoveMoneyCommand;
use Farmero\moneysystem\Commands\SeeMoneyCommand;
use Farmero\moneysystem\Commands\MyMoneyCommand;
use Farmero\moneysystem\Commands\TopMoneyCommand;
use Farmero\moneysystem\Commands\PayMoneyCommand;

class MoneySystem extends PluginBase {

    private static $instance;
    private $moneyManager;

    public function onLoad(): void {
        self::$instance = $this;
    }

    public function onEnable(): void {
        $this->moneyManager = new MoneyManager($this);
        $this->registerCommands();
    }

    private function registerCommands() {
        $this->getServer()->getCommandMap()->registerAll("MoneySystem", [
            new SetMoneyCommand(),
            new AddMoneyCommand(),
            new RemoveMoneyCommand(),
            new SeeMoneyCommand(),
            new MyMoneyCommand(),
            new TopMoneyCommand(),
            new PayMoneyCommand()
        ]);
    }

    public static function getInstance(): self {
        return self::$instance;
    }

    public function getMoneyManager(): MoneyManager {
        return $this->moneyManager;
    }
}