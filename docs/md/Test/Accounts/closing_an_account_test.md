## Scenario:

> Closing an account

### Given:

- Account was opened with id of __*123*__, first name of __*John*__, last name of __*Doe*__, amount of __*0*__.

### When:

Close account with id of __*123*__.

### Then:

- <font style='color: green !important;'>One event has been produced.</font>
- <font style='color: green !important;'>An `AccountWasClosed` event was produced.</font>
- <font style='color: green !important;'>The account is closed.</font>

---
*Rendered 02-01-2017.*
