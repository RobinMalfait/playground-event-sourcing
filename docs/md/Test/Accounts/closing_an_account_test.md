## Scenario:

> Closing an account

### Given:

- Account was opened with id of 123, first name of John, last name of Doe, amount of 0.

### When:

Close account with id of 123.

### Then:

- <font style='color: green !important;'>One event has been produced.</font>
- <font style='color: green !important;'>An `AccountWasClosed` event was produced.</font>
- <font style='color: green !important;'>The account is closed.</font>

---
*Rendered 02-01-2017.*
