# database-example
Simple DB with web frontend

For demonstration purposes, it might have some vulnerabilities

# Webshop example

`warehouse.ipynb` adds a simplistic webshop backend to the database

## Analytical queries
```
select country, avg(total_amount) as average, count(distinct o.order_id) as n_orders, count(distinct c.customer_id) as n_customers
from orders o, customers c, order_products op, products p
where o.customer_id = c.customer_id
  and o.order_id = op.order_id
  and op.product_id = p.product_id
  and p.category like '%e%'
group by country
order by average DESC
limit 10;
```

```
select country, category, avg(total_amount) as average, count(distinct o.order_id) as n_orders, count(distinct c.customer_id) as n_customers
from orders o, customers c, order_products op, products p
where o.customer_id = c.customer_id
  and o.order_id = op.order_id
  and op.product_id = p.product_id
group by country, category
order by average DESC
limit 20;
```
