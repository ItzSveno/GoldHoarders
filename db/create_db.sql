CREATE DATABASE bank;

USE bank;
--Creates Tables
CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE accounts (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  balance DECIMAL(10,2) NOT NULL,
  type ENUM('savings', 'checking') NOT NULL,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE transactions (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  from_account INT NOT NULL,
  to_account INT NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (from_account) REFERENCES accounts(id),
  FOREIGN KEY (to_account) REFERENCES accounts(id)
);
--Function to check if theres EnoughBalance
CREATE DEFINER=`admin`@`%` FUNCTION `EnoughBalance`(AccountID INT, Amount DECIMAL(10,2)) RETURNS int(11)
BEGIN
	DECLARE BalStatus INT;
    SET BalStatus = 0;
	IF(((SELECT balance FROM accounts WHERE id=AccountID) - Amount)>= 0) then
		SET BalStatus = 1;
	END IF;
	Return BalStatus;
END
--Function to TransferAmount
CREATE DEFINER=`admin`@`%` PROCEDURE `TransferAmount`(IN AccountFromID INTEGER,IN AccountToID INTEGER,IN Amount DECIMAL(10,2))
BEGIN
	IF((SELECT EnoughBalance(AccountFromID, Amount)) = 1 AND Amount >= 0) THEN
		START TRANSACTION;
			UPDATE accounts SET balance = (balance - Amount) WHERE id=AccountFromID;
			UPDATE accounts SET balance = (balance + Amount) WHERE id=AccountToID;
			INSERT INTO transactions(from_account, to_account, amount) VALUES (AccountFromID, AccountToID, Amount);
		COMMIT;
    END IF;
END

