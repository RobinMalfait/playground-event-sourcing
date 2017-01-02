## Scenario:

> Closing an account

### Given:

- Account was opened with an id of __*123*__, a first name of __*John*__, a last name of __*Doe*__, an amount of __*0*__.

### When:

Close account with an id of __*123*__.

### Then:

- <font style='color: green !important;'>One event has been produced.</font>
- <font style='color: green !important;'>An `AccountWasClosed` event was produced.</font>
- <font style='color: green !important;'>The account is closed.</font>

---
*Rendered 02-01-2017.*
