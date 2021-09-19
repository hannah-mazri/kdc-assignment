SELECT categories.CategoryID, categories.CategoryName, COUNT(categories.CategoryName) as Count
FROM orders
         JOIN order_details ON orders.OrderID = order_details.OrderID
         JOIN products ON order_details.ProductID = products.ProductID
         JOIN categories ON products.CategoryID = categories.CategoryID
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate <= '1995-06-01'
GROUP BY categories.CategoryID
ORDER BY categories.CategoryName;



SELECT categories.CategoryID,
       categories.CategoryName,
       SUM((order_details.UnitPrice * order_details.Quantity) -
           (order_details.Discount * order_details.Quantity)) as TotalSales
FROM orders
         JOIN order_details ON orders.OrderID = order_details.OrderID
         JOIN products ON order_details.ProductID = products.ProductID
         JOIN categories ON products.CategoryID = categories.CategoryID
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate <= '1995-06-01'
GROUP BY categories.CategoryID
ORDER BY TotalSales;