SELECT COUNT(orders.OrderID) AS TotalOrder
from orders
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate < '1995-06-01';