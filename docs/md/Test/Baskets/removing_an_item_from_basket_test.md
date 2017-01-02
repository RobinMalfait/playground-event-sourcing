## Scenario:

> Removing an item from basket

### Given:

- Basket was created with id of 123.
- Product was added to basket with basket id of 123, id of 321, name of Test Product.

### When:

Remove item with basket id of 123, id of 321.

### Then:

- <font style='color: green !important;'>One event was produced.</font>
- <font style='color: green !important;'>A `ProductWasDeletedFromBasket` event was produced.</font>
- <font style='color: green !important;'>There are no items in the basket.</font>

---
*Rendered 02-01-2017.*
