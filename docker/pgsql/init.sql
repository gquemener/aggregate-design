CREATE SEQUENCE Release_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE BacklogItem_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE Sprint_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE TABLE Release (id INT NOT NULL, product_id VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_51FA3A814584665A ON Release (product_id);
CREATE TABLE BacklogItem (id INT NOT NULL, product_id VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_33221A7F4584665A ON BacklogItem (product_id);
CREATE TABLE Product (id VARCHAR(255) NOT NULL, version INT DEFAULT 1 NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, tenantId_value VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE Sprint (id INT NOT NULL, product_id VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_E82C50814584665A ON Sprint (product_id);
ALTER TABLE Release ADD CONSTRAINT FK_51FA3A814584665A FOREIGN KEY (product_id) REFERENCES Product (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE BacklogItem ADD CONSTRAINT FK_33221A7F4584665A FOREIGN KEY (product_id) REFERENCES Product (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE Sprint ADD CONSTRAINT FK_E82C50814584665A FOREIGN KEY (product_id) REFERENCES Product (id) NOT DEFERRABLE INITIALLY IMMEDIATE;