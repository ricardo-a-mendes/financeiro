-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.9-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.4.0.5133
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para financeiro
CREATE DATABASE IF NOT EXISTS `financeiro` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `financeiro`;

-- Copiando estrutura para tabela financeiro.accounts
DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_type_id` int(10) unsigned NOT NULL,
  `name` varchar(145) NOT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_accounts_account_types_idx` (`account_type_id`),
  CONSTRAINT `fk_accounts_account_types` FOREIGN KEY (`account_type_id`) REFERENCES `account_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela financeiro.accounts: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` (`id`, `account_type_id`, `name`, `status`) VALUES
	(1, 1, 'Itau', 1),
	(2, 1, 'Santander', 1),
	(3, 1, 'Banco do Brasil', 1);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

-- Copiando estrutura para tabela financeiro.account_types
DROP TABLE IF EXISTS `account_types`;
CREATE TABLE IF NOT EXISTS `account_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unique_name` varchar(70) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unic_name_UNIQUE` (`unique_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela financeiro.account_types: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `account_types` DISABLE KEYS */;
INSERT INTO `account_types` (`id`, `unique_name`, `name`) VALUES
	(1, 'conta_corrente', 'Conta Corrente'),
	(2, 'conta_poupanca', 'Conta Poupança'),
	(3, 'cartao_credito', 'Cartão de Crédito');
/*!40000 ALTER TABLE `account_types` ENABLE KEYS */;

-- Copiando estrutura para tabela financeiro.categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(145) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela financeiro.categories: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `status`) VALUES
	(1, 'Aluguel', 1),
	(2, 'Salário', 1),
	(3, 'Teka', 1),
	(4, 'Farmácia', 1),
	(5, 'Padaria', 1),
	(6, 'Financiamento Apartamento', 1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Copiando estrutura para tabela financeiro.goals
DROP TABLE IF EXISTS `goals`;
CREATE TABLE IF NOT EXISTS `goals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `transaction_type_id` int(10) unsigned NOT NULL,
  `value` decimal(14,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_goals_categories_idx` (`category_id`),
  KEY `fk_goals_transaction_type_idx` (`transaction_type_id`),
  CONSTRAINT `fk_goals_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_goals_transaction_types` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela financeiro.goals: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `goals` DISABLE KEYS */;
INSERT INTO `goals` (`id`, `category_id`, `transaction_type_id`, `value`) VALUES
	(6, 3, 2, 300.00),
	(7, 4, 2, 280.00),
	(8, 4, 2, 290.00),
	(9, 6, 2, 3120.00),
	(10, 1, 1, 1400.00),
	(11, 2, 1, 5200.00),
	(12, 5, 2, 200.00),
	(13, 3, 2, 111.00);
/*!40000 ALTER TABLE `goals` ENABLE KEYS */;

-- Copiando estrutura para tabela financeiro.goal_dates
DROP TABLE IF EXISTS `goal_dates`;
CREATE TABLE IF NOT EXISTS `goal_dates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goal_id` int(10) unsigned NOT NULL,
  `target_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_goal_dates_goals_idx` (`goal_id`),
  CONSTRAINT `fk_goal_dates_goals` FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela financeiro.goal_dates: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `goal_dates` DISABLE KEYS */;
INSERT INTO `goal_dates` (`id`, `goal_id`, `target_date`) VALUES
	(2, 8, '2016-12-13 21:01:26'),
	(3, 9, '2016-12-30 19:12:50'),
	(4, 13, '2017-01-10 00:00:00');
/*!40000 ALTER TABLE `goal_dates` ENABLE KEYS */;

-- Copiando estrutura para tabela financeiro.incomes
DROP TABLE IF EXISTS `incomes`;
CREATE TABLE IF NOT EXISTS `incomes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `value` decimal(14,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_incomes_accounts_idx` (`account_id`),
  CONSTRAINT `fk_incomes_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela financeiro.incomes: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `incomes` DISABLE KEYS */;
INSERT INTO `incomes` (`id`, `account_id`, `value`, `status`) VALUES
	(1, 1, 5200.00, 1),
	(2, 2, 1400.00, 1);
/*!40000 ALTER TABLE `incomes` ENABLE KEYS */;

-- Copiando estrutura para tabela financeiro.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela financeiro.migrations: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Copiando estrutura para tabela financeiro.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela financeiro.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Copiando estrutura para tabela financeiro.transactions
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `transaction_type_id` int(10) unsigned NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `value` decimal(14,2) DEFAULT NULL,
  `transaction_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transactions_accounts_idx` (`account_id`),
  KEY `fk_transactions_categories_idx` (`category_id`),
  KEY `fk_transactions_transaction_types_idx` (`transaction_type_id`),
  CONSTRAINT `fk_transactions_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transactions_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transactions_transaction_types1` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela financeiro.transactions: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` (`id`, `account_id`, `category_id`, `transaction_type_id`, `description`, `value`, `transaction_date`) VALUES
	(3, 1, 1, 1, 'Recebimento Aluguel', 1438.00, '2016-12-13 19:19:46'),
	(4, 2, 3, 2, 'Pagamento Teka', 300.00, '2016-12-12 19:28:37'),
	(5, 1, 4, 2, 'Remédios', 268.00, '2016-12-13 19:33:45'),
	(8, 2, 4, 2, 'Ultrafarma', 56.00, '2016-12-13 20:47:29'),
	(9, 1, 2, 1, 'Salario Mensal', 5300.00, '2016-12-24 03:00:09'),
	(11, 1, 3, 2, 'Ração Teka', 129.00, '2016-12-01 23:57:07'),
	(12, 2, 3, 2, 'Pagamento Teka', 300.00, '2017-01-09 23:12:30'),
	(13, 2, 4, 2, 'Dorflex', 35.03, '2017-01-01 00:00:00');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;

-- Copiando estrutura para tabela financeiro.transaction_types
DROP TABLE IF EXISTS `transaction_types`;
CREATE TABLE IF NOT EXISTS `transaction_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unique_name` varchar(70) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unic_name_UNIQUE` (`unique_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela financeiro.transaction_types: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `transaction_types` DISABLE KEYS */;
INSERT INTO `transaction_types` (`id`, `unique_name`, `name`) VALUES
	(1, 'credit', 'Crédito'),
	(2, 'debit', 'Débito');
/*!40000 ALTER TABLE `transaction_types` ENABLE KEYS */;

-- Copiando estrutura para tabela financeiro.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela financeiro.users: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Ricardo', 'eng.rmendes@gmail.com', '$2y$10$7RbBiJ/TK1zMv3RGHgvtre42..KlmZzEFGp85XIOvZ4MHanBegCOO', 'secret', '2016-12-24 03:27:15', '2016-12-24 03:27:15');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
