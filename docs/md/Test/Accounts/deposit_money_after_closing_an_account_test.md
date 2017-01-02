## Scenario:

> Deposit money after closing an account

### Given:

- Account was opened with id of __*123*__, first name of __*John*__, last name of __*Doe*__, amount of __*0*__.
- Account was closed with id of __*123*__.

### When:

Deposit money with id of __*123*__, amount of __*50*__.

### Then:

- <font style='color: green !important;'>None events have been produced.</font>
- <font style='color: green !important;'>An `AccountClosedException` was thrown.</font>

---
*Rendered 02-01-2017.*
