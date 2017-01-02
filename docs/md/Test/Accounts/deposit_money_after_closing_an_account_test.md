## Scenario:

> Deposit money after closing an account

### Given:

- Account was opened with an id of __*123*__, a first name of __*John*__, a last name of __*Doe*__, an amount of __*0*__.
- Account was closed with an id of __*123*__.

### When:

Deposit money with an id of __*123*__, an amount of __*50*__.

### Then:

- <font style='color: green !important;'>None events have been produced.</font>
- <font style='color: green !important;'>An `AccountClosedException` was thrown.</font>

---
*Rendered 02-01-2017.*
