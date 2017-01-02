## Scenario:

> Deposit money after closing an account

### Given:

- Account was opened with id of 123, first name of John, last name of Doe, amount of 0.
- Account was closed with id of 123.

### When:

Deposit money with id of 123, amount of 50.

### Then:

- <font style='color: green !important;'>None events have been produced.</font>
- <font style='color: green !important;'>An `AccountClosedException` was thrown.</font>

---
*Rendered 02-01-2017.*
