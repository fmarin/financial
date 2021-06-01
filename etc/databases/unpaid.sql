CREATE TABLE `debt_rejections` (
    `id` CHAR(36) NOT NULL,
    `bank_file_name` VARCHAR(20) NOT NULL,
    `creation_date_time` DATETIME NOT NULL,
    `refund_id` VARCHAR(6) NOT NULL,
    `internal_id` VARCHAR(10) NOT NULL,
    `transaction_status` VARCHAR(10) NOT NULL,
    `status_reason_code` VARCHAR(10) NOT NULL,
    `debt_amount` DECIMAL(10,2) NOT NULL,
    `payment_date` DATE NOT NULL,
    `debtor_account` VARCHAR(30) NOT NULL,
    `creditor_account` VARCHAR(30) NOT NULL,
    `debtor_name` VARCHAR(255) NOT NULL,
    `process_status` TINYINT(1) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
