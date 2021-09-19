SELECT orders.EmployeeID, employees.FirstName, COUNT(employees.EmployeeID) as Count
FROM orders
         JOIN employees ON orders.EmployeeID = employees.EmployeeID
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate < '1995-06-01'
GROUP BY employees.EmployeeID
ORDER BY employees.FirstName;


SELECT employees.EmployeeID,
       CONCAT(employees.FirstName, ' ', employees.LastName)   AS FullName,
       SUM((order_details.UnitPrice * order_details.Quantity) -
           (order_details.Discount * order_details.Quantity)) as TotalSales
FROM orders
         JOIN order_details ON orders.OrderID = order_details.OrderID
         JOIN employees ON orders.EmployeeID = employees.EmployeeID
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate < '1995-06-01'
GROUP BY employees.EmployeeID
ORDER BY TotalSales;