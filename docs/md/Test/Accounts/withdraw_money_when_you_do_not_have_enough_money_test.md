## Scenario:

> Withdraw money when you do not have enough money

### Given:

- Account was opened with an id of __*123*__, a first name of __*John*__, a last name of __*Doe*__, an amount of __*0*__.

### When:

Withdraw money with an id of __*123*__, an amount of __*75*__.

### Then:

- <font style='color: green !important;'>None events have been produced.</font>
- <font style='color: green !important;'>An `AccountDoesNotHaveEnoughMoneyException` was thrown.</font>

---
*Rendered 02-01-2017.*
