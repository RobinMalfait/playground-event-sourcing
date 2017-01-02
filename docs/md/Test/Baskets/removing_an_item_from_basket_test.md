## Scenario:

> Removing an item from basket

### Given:

- Basket was created with an id of __*123*__.
- Product was added to basket with an id of __*123*__, an id of __*321*__, a name of __*Test Product*__.

### When:

Remove item with an id of __*123*__, an id of __*321*__.

### Then:

- <font style='color: green !important;'>One event was produced.</font>
- <font style='color: green !important;'>A `ProductWasDeletedFromBasket` event was produced.</font>
- <font style='color: green !important;'>There are no items in the basket.</font>

---
*Rendered 02-01-2017.*
