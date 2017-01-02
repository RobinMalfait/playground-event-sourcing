## Scenario:

> Deposit money

### Given:

- Account was opened with an id of __*123*__, a first name of __*John*__, a last name of __*Doe*__, an amount of __*0*__.

### When:

Deposit money with an id of __*123*__, an amount of __*50*__.

### Then:

- <font style='color: green !important;'>One event has been produced.</font>
- <font style='color: green !important;'>A `MoneyWasDeposited` event was produced.</font>
- <font style='color: green !important;'>The account has been deposited with 50.</font>
- <font style='color: green !important;'>The current balance should be 50.</font>

---
*Rendered 02-01-2017.*
