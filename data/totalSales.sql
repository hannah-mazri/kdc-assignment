SELECT SUM((order_details.UnitPrice * order_details.Quantity) -
           (order_details.Discount * order_details.Quantity)) as TotalSales
FROM orders
         JOIN order_details ON orders.OrderID = order_details.OrderID
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate < '1995-06-01';