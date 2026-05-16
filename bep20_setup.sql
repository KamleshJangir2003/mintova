-- Run this SQL in phpMyAdmin to add BEP20 support

ALTER TABLE `imaksoft_settings_qr` 
  ADD COLUMN IF NOT EXISTS `bep20_wallet_address` varchar(255) NOT NULL DEFAULT '' AFTER `qr_image`,
  ADD COLUMN IF NOT EXISTS `bep20_qr_image` varchar(255) NOT NULL DEFAULT '' AFTER `bep20_wallet_address`;
