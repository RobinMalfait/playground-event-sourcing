## Scenario:

> Withdraw money

### Given:

- Account was opened with id of __*123*__, first name of __*John*__, last name of __*Doe*__, amount of __*0*__.
- Money was deposited with id of __*123*__, amount of __*100*__.

### When:

Withdraw money with id of __*123*__, amount of __*75*__.

### Then:

- <font style='color: green !important;'>One event has been produced.</font>
- <font style='color: green !important;'>A `MoneyWasWithdrawn` event was produced.</font>
- <font style='color: green !important;'>The new saldo is 25.</font>

---
*Rendered 02-01-2017.*
