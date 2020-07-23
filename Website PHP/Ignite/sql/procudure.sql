CREATE OR REPLACE PACKAGE customer_pk
AS
PROCEDURE deactivate_customer(user_name IN NUMBER);
END customer_pk;

CREATE OR REPLACE PACKAGE BODY customer_pk
AS
PROCEDURE deactivate_customer
(user_name IN NUMBER) IS 
 BEGIN
   UPDATE USERS SET ACTIVE=1 WHERE user_id = user_name; 
 END deactivate_customer;
 END customer_pk;
 /
 
 CREATE OR REPLACE PACKAGE activate_customer
AS
PROCEDURE activate_customer(user_name IN NUMBER);
END activate_customer;

CREATE OR REPLACE PACKAGE BODY activate_customer
AS
PROCEDURE activate_customer
(user_name IN NUMBER) IS 
 BEGIN
   UPDATE USERS SET ACTIVE=0 WHERE user_id = user_name; 
 END activate_customer;
 END activate_customer;
 /