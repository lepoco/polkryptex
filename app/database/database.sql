-- Sessions table
CREATE TABLE IF NOT EXISTS forward_sessions (
	session_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT (6),
	session_key INT (20) NOT NULL,
	session_content LONGTEXT
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Users table
CREATE TABLE IF NOT EXISTS forward_users (
	user_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_name VARCHAR (128) NOT NULL,
	user_display_name VARCHAR (128),
	user_email VARCHAR (256),
	user_password VARCHAR (1024) NOT NULL,
	user_token VARCHAR (256),
	user_role VARCHAR (256),
	user_status INT (2) NOT NULL DEFAULT 0,
	user_registered DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	user_last_login DATETIME DEFAULT NULL
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Global statistics types
CREATE TABLE IF NOT EXISTS forward_global_statistics_types (
	type_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	type_name VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_global_statistics_types (type_name) VALUES ('unknown') ON DUPLICATE KEY UPDATE type_name=type_name;
INSERT IGNORE INTO forward_global_statistics_types (type_name) VALUES ('query') ON DUPLICATE KEY UPDATE type_name=type_name;
INSERT IGNORE INTO forward_global_statistics_types (type_name) VALUES ('page') ON DUPLICATE KEY UPDATE type_name=type_name;
INSERT IGNORE INTO forward_global_statistics_types (type_name) VALUES ('action') ON DUPLICATE KEY UPDATE type_name=type_name;

-- Global statistics types
CREATE TABLE IF NOT EXISTS forward_global_statistics_tags (
	tag_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	tag_name VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_global_statistics_tags (tag_name) VALUES ('unknown') ON DUPLICATE KEY UPDATE tag_name=tag_name;

-- Global statistics
CREATE TABLE IF NOT EXISTS forward_global_statistics (
	statistic_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	statistic_type INT (6) UNSIGNED NOT NULL DEFAULT 1,
	CONSTRAINT fk_statistic_type FOREIGN KEY (statistic_type) REFERENCES forward_global_statistics_types (type_id),
	statistic_tag INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_statistic_tag FOREIGN KEY (statistic_tag) REFERENCES forward_global_statistics_tags (tag_id),
	statistic_user_id INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_statistic_user_id FOREIGN KEY (statistic_user_id) REFERENCES forward_users (user_id),
	statistic_user_logged_in BOOLEAN DEFAULT false,
	statistic_ip VARCHAR (39),
	statistic_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8 COLLATE utf8_general_ci;