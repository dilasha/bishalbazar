--SEQUENCES
DROP SEQUENCE userSeq;
CREATE SEQUENCE userSeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

DROP SEQUENCE catSeq;
CREATE SEQUENCE catSeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

DROP SEQUENCE messageSeq;
CREATE SEQUENCE messageSeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

DROP SEQUENCE sliderSeq;
CREATE SEQUENCE sliderSeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

DROP SEQUENCE orderSeq;
CREATE SEQUENCE orderSeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

DROP SEQUENCE shopSeq;
CREATE SEQUENCE shopSeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

DROP SEQUENCE categorySeq;
CREATE SEQUENCE categorySeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

DROP SEQUENCE productSeq;
CREATE SEQUENCE productSeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

DROP SEQUENCE  billSeq;
CREATE SEQUENCE billSeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

DROP SEQUENCE paymentSeq;
CREATE SEQUENCE paymentSeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

DROP SEQUENCE salesSeq;
CREATE SEQUENCE salesSeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

DROP SEQUENCE slotSeq;
CREATE SEQUENCE slotSeq
MINVALUE 1 START WITH 1
INCREMENT BY 1 CACHE 10;

--TABLES AND CONSTRAINTS

DROP TABLE user_account CASCADE CONSTRAINTS;
CREATE TABLE user_account(
    userID int PRIMARY KEY,
    userName VARCHAR(255) NOT NULL,
    userEmail VARCHAR2(255) NOT NULL,
    userPassword VARCHAR2(255) NOT NULL,
    userRole VARCHAR2(255) NOT NULL,
    userStatus VARCHAR2(255),
    userPic VARCHAR2(255));

DROP TABLE category CASCADE CONSTRAINTS;
CREATE TABLE category(
    catID int PRIMARY KEY,
    catName VARCHAR2(255) NOT NULL,
    catDesc VARCHAR2(255));

DROP TABLE message CASCADE CONSTRAINTS;
CREATE TABLE message(
    msgID int PRIMARY KEY,
    msgSender VARCHAR2(255),
    msgReciever VARCHAR2(255) NOT NULL,
    msgText VARCHAR2(255),
    msgType VARCHAR2(255),
    msgTime VARCHAR2(255));

DROP TABLE slider CASCADE CONSTRAINTS;
CREATE TABLE slider(
    sliderID int PRIMARY KEY,
    sliderDesc VARCHAR2(255) NOT NULL,
    sliderTitle VARCHAR2(255) NOT NULL,
    sliderLink VARCHAR2(255) NOT NULL,
    sliderImg VARCHAR2(255) NOT NULL);
  
DROP TABLE shop CASCADE CONSTRAINTS;
CREATE TABLE shop(
    shopID int PRIMARY KEY,
    userID int,
    shopName VARCHAR2(255) NOT NULL,
    shopImg VARCHAR2(255),
    floorNum int NOT NULL,
    shopStatus VARCHAR2(255));

ALTER TABLE shop
    ADD CONSTRAINT fk_shopUserID
    FOREIGN KEY (userID)
    REFERENCES user_account(userID)
    ON DELETE CASCADE;

DROP TABLE product CASCADE CONSTRAINTS;
CREATE TABLE product(
    prodID int PRIMARY KEY,
    shopID int,
    prodName VARCHAR2(255) NOT NULL,
    prodRate int NOT NULL,
    prodImg VARCHAR2(255) NOT NULL,
    prodCategory int NOT NULL,
    prodFeat VARCHAR2(5));

ALTER TABLE product
    ADD CONSTRAINT fk_productShopID
    FOREIGN KEY (shopID)
    REFERENCES shop(shopID)
    ON DELETE CASCADE;

ALTER TABLE product
    ADD CONSTRAINT fk_productCatID
    FOREIGN KEY (prodCategory)
    REFERENCES category(catID)
    ON DELETE CASCADE;

DROP TABLE bill CASCADE CONSTRAINTS;
CREATE TABLE bill(
    billID int PRIMARY KEY,
    custID int,
    billAmount int);

ALTER TABLE bill
    ADD CONSTRAINT fk_billUserID
    FOREIGN KEY (custID)
    REFERENCES user_account(userID)
    ON DELETE CASCADE;
    
DROP TABLE c_order CASCADE CONSTRAINTS;
CREATE TABLE c_order(
    orderID int PRIMARY KEY,
    custID int NOT NULL,
    shopID int NOT NULL,
    prodID int NOT NULL,
    quantity int NOT NULL);

ALTER TABLE c_order
    ADD CONSTRAINT fk_orderUserID
    FOREIGN KEY (custID)
    REFERENCES user_account(userID)
    ON DELETE CASCADE;

ALTER TABLE c_order
    ADD CONSTRAINT fk_orderShopID
    FOREIGN KEY (shopID)
    REFERENCES shop(shopID)
    ON DELETE CASCADE;

ALTER TABLE c_order
    ADD CONSTRAINT fk_c_orderProdID
    FOREIGN KEY (prodID)
    REFERENCES product(prodID)
    ON DELETE CASCADE;


DROP TABLE slot CASCADE CONSTRAINTS;
CREATE TABLE slot(
    slotID int PRIMARY KEY,
    timeStart VARCHAR2(255) NOT NULL,
    timeFinish VARCHAR2(255) NOT NULL,
    collectDate DATE,
    paymentTime VARCHAR2(255),
    paymentDate DATE);

DROP TABLE payment CASCADE CONSTRAINTS;
CREATE TABLE payment(
    paymentID int PRIMARY KEY,
    billID int,
    custID int,
    slotID int,
    transactionID VARCHAR(255));

ALTER TABLE payment
    ADD CONSTRAINT fk_paymentBillID
    FOREIGN KEY (billID)
    REFERENCES bill(billID)
    ON DELETE CASCADE;

ALTER TABLE payment
    ADD CONSTRAINT fk_paymentUserID
    FOREIGN KEY (custID)
    REFERENCES user_account(userID)
    ON DELETE CASCADE;

ALTER TABLE payment
    ADD CONSTRAINT fk_paymentSlotID
    FOREIGN KEY (slotID)
    REFERENCES slot(slotID)
    ON DELETE CASCADE;

DROP TABLE sales CASCADE CONSTRAINTS;
CREATE TABLE sales(
    salesID int PRIMARY KEY,
    prodID int,
    sellerID int,
    shopID int,
    custID int,
    quantity int,
    paymentID int);   


ALTER TABLE sales
    ADD CONSTRAINT fk_salesPaymentID
    FOREIGN KEY (paymentID)
    REFERENCES payment(paymentID)
    ON DELETE CASCADE;

ALTER TABLE sales
    ADD CONSTRAINT fk_prodID
    FOREIGN KEY (prodID)
    REFERENCES product(prodID)
    ON DELETE CASCADE;

ALTER TABLE sales
    ADD CONSTRAINT fk_sellerIDSales
    FOREIGN KEY (sellerID)
    REFERENCES user_account(userID)
    ON DELETE CASCADE;

ALTER TABLE sales
    ADD CONSTRAINT fk_shopIDSales
    FOREIGN KEY (shopID)
    REFERENCES shop(shopID)
    ON DELETE CASCADE;

ALTER TABLE sales
    ADD CONSTRAINT fk_custIDSales
    FOREIGN KEY (custID)
    REFERENCES user_account(userID)
    ON DELETE CASCADE;

--VIEWS FOR REPORTS
drop view purchaseHistory;
create view purchaseHistory as
select u.userName as sellerName, s.custID , sh.shopName, p.prodName, p.prodRate, s.quantity, (s.quantity*p.prodRate) as 

prodAmt, sl.paymentDate from sales s, shop sh, payment py, slot sl, user_account u, product p 
where s.paymentID=py.paymentID and s.prodID=p.prodID and s.shopID=sh.shopID and sl.slotID=py.slotID and 

s.sellerID=u.userID;

drop view productSales;    
create view productSales as
select p.prodName, sum(s.quantity) as numSales
from product p, sales s 
where s.prodID=p.prodID 
group by p.prodName
order by p.prodName;

drop view traderSales;
create view traderSales as
select sellerID, shopName, prodName, SUM(quantity*prodRate) as Amount from product p, shop sh, sales s where 

sh.shopID=s.shopID and p.prodID=s.prodID group by prodName, shopName, sellerID;


--SUPERADMIN DATA (FOR FIRST LOGIN)
INSERT INTO user_account VALUES (userSeq.nextVal,'Admin 

1','admin@team.6','86f7e437faa5a7fce15d1ddcb9eaeaea377667b8','Admin','Verified','userPic.jpg');


​