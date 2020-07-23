CREATE OR REPLACE FORCE VIEW  "DAILY_REPORT" ("TRADER_ID", "PRODUCT_ID", "PRODUCT_NAME", "PRICE", "QUANTITY", "SLOT_DATE", "SLOT_TIME", "PRODUCT_IMAGE") AS 
  SELECT a.trader_id, a.product_id, a.product_name, a.price, a.quantity, a.slot_date, a.slot_time, a.product_image FROM
    trader_orders a,
    collection_slot b
WHERE
    a.slot_id = b.slot_id AND to_date(a.slot_date,'YYYY-MM-DD') >= sysdate
/


CREATE OR REPLACE FORCE VIEW  "MONTHLY_REPORT" ("TRADER_ID", "PRODUCT_ID", "PRICE", "QUANTITY", "SLOT_DATE", "SLOT_TIME", "PRODUCT_IMAGE") AS 
  SELECT a.trader_id, a.product_id, a.price, a.quantity, a.slot_date, a.slot_time, a.product_image FROM
    trader_orders a,
    collection_slot b
WHERE
    a.slot_id = b.slot_id AND to_date(a.slot_date,'YYYY-MM-DD') > sysdate-30
/


CREATE OR REPLACE FORCE VIEW  "TRADER_ORDERS" ("ORDER_ID", "USER_ID", "PRODUCT_IMAGE", "PRODUCT_ID", "PRODUCT_NAME", "PRICE", "TRADER_ID", "QUANTITY", "SLOT_ID", "SLOT_DATE", "SLOT_TIME") AS 
  SELECT orders.order_id, orders.user_id,product.product_image,product.product_id,product.product_name,product.price,trader.trader_id,orders.quantity,collection_slot.slot_id,collection_slot.slot_date,collection_slot.slot_time FROM 
collection_slot,orders,product,product_type,shop,trader
where 

collection_slot.slot_id =  orders.slot_id and
orders.product_id = product.product_id and product.product_type_id = product_type.product_type_id
and product_type.shop_id = shop.shop_id and shop.trader_id = trader.trader_id
/

CREATE OR REPLACE FORCE VIEW  "TRADER_PRODUCTS" ("PRODUCT_ID", "QUANTITY", "TRADER_ID") AS 
  SELECT p.product_id, p.quantity, t.trader_id from 
trader t, product p, shop s, product_type pt
WHERE
    p.product_type_id = pt.product_type_id and
    pt.shop_id = s.shop_id and
    s.trader_id = t.trader_id
/

CREATE OR REPLACE FORCE VIEW  "WEEKLY_REPORT" ("TRADER_ID", "PRODUCT_ID", "PRICE", "QUANTITY", "SLOT_DATE", "SLOT_TIME", "PRODUCT_IMAGE") AS 
  SELECT a.trader_id, a.product_id, a.price, a.quantity, a.slot_date, a.slot_time, a.product_image FROM
    trader_orders a,
    collection_slot b
WHERE
    a.slot_id = b.slot_id AND to_date(a.slot_date,'YYYY-MM-DD') > sysdate-7
/


