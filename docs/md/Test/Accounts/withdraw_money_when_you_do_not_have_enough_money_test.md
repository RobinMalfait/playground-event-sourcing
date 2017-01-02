## Scenario:

> Withdraw money when you do not have enough money

### Given:

- Account was opened with id of __*123*__, first name of __*John*__, last name of __*Doe*__, amount of __*0*__.

### When:

Withdraw money with id of __*123*__, amount of __*75*__.

### Then:

- <font style='color: green !important;'>None events have been produced.</font>
- <font style='color: green !important;'>An `AccountDoesNotHaveEnoughMoneyException` was thrown.</font>

---
*Rendered 02-01-2017.*
