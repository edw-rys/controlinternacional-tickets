ALTER TABLE `users` ADD `company_id` INT(10) UNSIGNED NULL DEFAULT NULL ;
ALTER TABLE `users` ADD `station_id` INT(10) UNSIGNED NULL DEFAULT NULL ;
ALTER TABLE `users` ADD `station_name` text NULL DEFAULT NULL ;
ALTER TABLE `users` ADD `station_code` text NULL DEFAULT NULL ;
ALTER TABLE `users` ADD `station_street` text NULL DEFAULT NULL ;
ALTER TABLE `users` ADD `deleted_at` datetime NULL DEFAULT NULL ;


ALTER TABLE `users`
  ADD KEY `hoses_company_id_foreign` (`company_id`),
  ADD KEY `hoses_station_id_foreign` (`station_id`);





ALTER TABLE `customers` ADD `company_id` INT(10) UNSIGNED NULL DEFAULT NULL ;
ALTER TABLE `customers` ADD `station_id` INT(10) UNSIGNED NULL DEFAULT NULL ;
ALTER TABLE `customers` ADD `station_name` text NULL DEFAULT NULL ;
ALTER TABLE `customers` ADD `station_code` text NULL DEFAULT NULL ;
ALTER TABLE `customers` ADD `station_street` text NULL DEFAULT NULL ;
ALTER TABLE `customers` ADD `deleted_at` datetime NULL DEFAULT NULL ;
ALTER TABLE `customers`
  ADD KEY `customer_company_id_foreign` (`company_id`),
  ADD KEY `customer_station_id_foreign` (`station_id`);


--
-- Estructura de tabla para la tabla `hose_types`
--

CREATE TABLE `hose_types` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Identifier',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name',
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Code',
  `octane_type` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Octane type: S=Super, E=Extra/Ecopais, F=Flash point',
  `color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Color name',
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Activated',
  `reference_id` int(10) UNSIGNED NOT NULL COMMENT 'reference id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Indices de la tabla `hose_types`
--
ALTER TABLE `hose_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hose_types_reference_id_foreign` (`reference_id`);

--
-- AUTO_INCREMENT de la tabla `hose_types`
--
ALTER TABLE `hose_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier';




CREATE TABLE `hoses` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Identifier',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name',
  `current_seal` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Current seal',
  `color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Color name',
  `company_id` int(10) UNSIGNED NOT NULL COMMENT 'Company identifier',
  `station_id` int(10) UNSIGNED NOT NULL COMMENT 'Station identifier',
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Station identifier',
  `hose_type_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT 'Hose type identifier',
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Activated',
  `reference_id` int(10) UNSIGNED NOT NULL COMMENT 'reference id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `hoses`
--
ALTER TABLE `hoses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hoses_hose_type_id_foreign` (`hose_type_id`),
  ADD KEY `hoses_station_id_foreign` (`station_id`),
  ADD KEY `hoses_company_id_foreign` (`company_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hoses`
--
ALTER TABLE `hoses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier';

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `hoses`
--
ALTER TABLE `hoses`
  ADD CONSTRAINT `hoses_hose_type_id_foreign` FOREIGN KEY (`hose_type_id`) REFERENCES `hose_types` (`id`),
  ADD CONSTRAINT `hoses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`);



ALTER TABLE `tickets` ADD `hose_id` int(10) UNSIGNED NULL DEFAULT NULL ;
-- ALTER TABLE `tickets` change `hose_id` `hose_id` int(10) UNSIGNED NULL DEFAULT NULL ;
ALTER TABLE `tickets` ADD `deleted_at` datetime NULL DEFAULT NULL ;


ALTER TABLE `tickets`
  ADD KEY `hoses_hose_hose_id_foreign` (`hose_id`),
  ADD CONSTRAINT `hoses_hose_hose_id_foreign` FOREIGN KEY (`hose_id`) REFERENCES `hoses` (`id`);










-- EN CONTROLINTERNACIONAL


ALTER TABLE `stations` ADD `email_customer` text NULL DEFAULT NULL ;
