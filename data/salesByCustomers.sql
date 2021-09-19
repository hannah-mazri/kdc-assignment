SELECT orders.CustomerID, customers.ContactName, COUNT(customers.CustomerID) as Count
FROM orders
         JOIN customers ON orders.CustomerID = customers.CustomerID
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate < '1995-06-01'
GROUP BY customers.CustomerID
ORDER BY customers.ContactName;



SELECT customers.CustomerID,
       customers.ContactName,
       SUM((order_details.UnitPrice * order_details.Quantity) -
           (order_details.Discount * order_details.Quantity)) as TotalSales
FROM orders
         JOIN order_details ON orders.OrderID = order_details.OrderID
         JOIN customers ON orders.CustomerID = customers.CustomerID
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate < '1995-06-01'
GROUP BY customers.CustomerID
ORDER BY TotalSales;


SELECT *
FROM (SELECT customers.CustomerID,
             customers.ContactName,
             SUM((order_details.UnitPrice * order_details.Quantity) -
                 (order_details.Discount * order_details.Quantity)) as TotalSales
      FROM orders
               JOIN order_details ON orders.OrderID = order_details.OrderID
               JOIN customers ON orders.CustomerID = customers.CustomerID
      WHERE orders.OrderDate >= '1995-05-01'
        and orders.OrderDate < '1995-06-01'
      GROUP BY customers.CustomerID
      ORDER BY TotalSales DESC
      LIMIT 9) a
ORDER BY a.TotalSales;