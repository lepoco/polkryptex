-- Options
CREATE TABLE IF NOT EXISTS pkx_options (
	option_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	option_name VARCHAR (64) NOT NULL,
	option_value LONGTEXT
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- User's roles 
CREATE TABLE IF NOT EXISTS pkx_user_roles (
	role_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	role_name VARCHAR (64) NOT NULL,
	role_permissions VARCHAR (256) NOT NULL
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Users
CREATE TABLE IF NOT EXISTS pkx_users (
	user_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_name VARCHAR (128) NOT NULL,
	user_display_name VARCHAR (128),
	user_email VARCHAR (256),
	user_password VARCHAR (1024) NOT NULL,
	user_session_token VARCHAR (256),
	user_cookie_token VARCHAR (256),
	user_role INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_user_role FOREIGN KEY (user_role) REFERENCES pkx_user_roles (role_id),
	user_status BOOLEAN DEFAULT false,
	user_registered DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	user_last_login DATETIME DEFAULT NULL,
	user_uuid VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Currencies 
CREATE TABLE IF NOT EXISTS pkx_currency (
	currency_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	currency_name VARCHAR (64) NOT NULL,
	currency_rate FLOAT NOT NULL,
	currency_is_crypto BOOLEAN DEFAULT false
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Wallets
CREATE TABLE IF NOT EXISTS pkx_wallets (
	wallet_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	wallet_currency_id INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_wallet_currency_id FOREIGN KEY (wallet_currency_id) REFERENCES pkx_currency (currency_id),
	wallet_user_id INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_wallet_user_id FOREIGN KEY (wallet_user_id) REFERENCES pkx_users (user_id)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Transactions
CREATE TABLE IF NOT EXISTS pkx_transactions (
	transaction_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	transaction_user_id INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_transaction_user_id FOREIGN KEY (transaction_user_id) REFERENCES pkx_users (user_id),
	transaction_from_wallet_id INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_transaction_from_wallet_id FOREIGN KEY (transaction_from_wallet_id) REFERENCES pkx_wallets (wallet_id),
	transaction_to_wallet_id INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_transaction_to_wallet_id FOREIGN KEY (transaction_to_wallet_id) REFERENCES pkx_wallets (wallet_id),
	transaction_uuid VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Statistics tags
CREATE TABLE IF NOT EXISTS pkx_statistics_tags (
	tag_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	tag_name VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Statistics types
CREATE TABLE IF NOT EXISTS pkx_statistics_types (
	type_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	type_name VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Statistics
CREATE TABLE IF NOT EXISTS pkx_statistics (
	statistic_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	statistic_type INT (6) UNSIGNED NOT NULL DEFAULT 1,
	CONSTRAINT fk_statistic_type FOREIGN KEY (statistic_type) REFERENCES pkx_statistics_types (type_id),
	statistic_tag INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_statistic_tag FOREIGN KEY (statistic_tag) REFERENCES pkx_statistics_tags (tag_id),
	statistic_user_id INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_statistic_user_id FOREIGN KEY (statistic_user_id) REFERENCES pkx_users (user_id),
	statistic_user_logged_in BOOLEAN DEFAULT false,
	statistic_ip VARCHAR (39),
	statistic_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8 COLLATE utf8_general_ci;