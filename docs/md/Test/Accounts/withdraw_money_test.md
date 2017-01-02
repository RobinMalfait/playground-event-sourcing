## Scenario:

> Withdraw money

### Given:

- Account was opened with id of 123, first name of John, last name of Doe, amount of 0.
- Money was deposited with account id of 123, amount of 100.

### When:

Withdraw money with id of 123, amount of 75.

### Then:

- <font style='color: green !important;'>One event has been produced.</font>
- <font style='color: green !important;'>An `MoneyWasWithdrawn` event was produced.</font>
- <font style='color: green !important;'>The new saldo is 25.</font>

---
*Rendered 02-01-2017.*
