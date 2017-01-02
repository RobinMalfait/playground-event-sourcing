## Scenario:

> Deposit money

### Given:

- Account was opened with id of 123, first name of John, last name of Doe, amount of 0.

### When:

Deposit money with id of 123, amount of 50.

### Then:

- <font style='color: green !important;'>One event has been produced.</font>
- <font style='color: green !important;'>An `MoneyWasDeposited` event was produced.</font>
- <font style='color: green !important;'>The account has been deposited with 50.</font>
- <font style='color: green !important;'>The current balance should be 50.</font>

---
*Rendered 02-01-2017.*
