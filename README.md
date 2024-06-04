# MoneySystem
Mostly for my server but its open source so go crazy!

**ScoreHud Tags**

Requires ScoreHud by Ifera
`{moneysystem.balance}`

# API
**Import the class**
```
use Farmero\moneysystem\MoneySystem;
```
**Initialize the API**
```
$economy = MoneySystem::getInstance->getMoneyManager();
```
**How to set a players balance**
```
$economy->setMoney($player, $amount);
```
**How to add money to a player balance**
```
$economy->addMoney($player, $amount);
```
**How to remove money from a player balance**
```
$economy->removeMoney($player, $amount);
```
**How to get a players balance**
```
$economy->getMoney($player);
```
**How to get all the balances from the data file**
```
$economy->getAllMoneyData();
```
