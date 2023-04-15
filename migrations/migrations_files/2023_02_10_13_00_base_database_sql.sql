--
-- Estructura de tabla para la tabla `nombredeevento_migraciones`
--

CREATE TABLE `migrations`
(
    `id`             int(11) NOT NULL,
    `migration`      varchar(255) NOT NULL,
    `execution_date` datetime     NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_log`
--

CREATE TABLE `login_log`
(
    `id`        int(11) NOT NULL,
    `id_user`   int(11) DEFAULT NULL,
    `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `login_log`
--

CREATE TRIGGER `login_log_after_insert`
    AFTER INSERT
    ON `login_log`
    FOR EACH ROW UPDATE users
                 SET last_login = NEW.timestamp
                 WHERE id = NEW.id_user;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles`
(
    `id`        int(11) NOT NULL,
    `name_show` varchar(255) NOT NULL,
    `name`      varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users`
(
    `id`         int(11) NOT NULL,
    `name`       varchar(255) NOT NULL,
    `email`      varchar(200) NOT NULL,
    `password`   varchar(300) NOT NULL,
    `photo`      varchar(255) DEFAULT NULL,
    `active`     int(11) NOT NULL DEFAULT 1,
    `id_rol`     int(11) NOT NULL DEFAULT 2,
    `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_invitation`
--

CREATE TABLE `user_invitation`
(
    `id`      int(11) NOT NULL,
    `name`    varchar(255) NOT NULL,
    `email`   varchar(255) NOT NULL,
    `id_user` int(11) DEFAULT NULL,
    `id_role` int(11) NOT NULL,
    `active`  int(11) NOT NULL,
    `token`   varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `company`
(
    `id`         int(11) NOT NULL,
    `name`       varchar(100) NOT NULL,
    `direction`  varchar(255) NOT NULL,
    `phone`      int(11) NOT NULL,
    `email`      varchar(200) NOT NULL,
    `url`        varchar(300) NOT NULL,
    `active`     int(1) NOT NULL DEFAULT 1,
    `provincia`  varchar(100) NOT NULL,
    `id_creator` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `popularity`
(
    `id`         int(11) NOT NULL,
    `id_user`    int(11) NOT NULL,
    `id_company` int(11) NOT NULL,
    `vote`       int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indices de la tabla `login_log`
--
ALTER TABLE `login_log`
    ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
    ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD KEY `rol` (`id_rol`);

--
-- Indices de la tabla `company`
--
ALTER TABLE `company`
    ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `popularity``
--
ALTER TABLE `popularity`
    ADD PRIMARY KEY (`id`,`id_user`,`id_company`);

--
-- Indices de la tabla `user_invitation`
--
ALTER TABLE `user_invitation`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `invitation_role` (`id_role`),
  ADD KEY `invitation_user` (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `login_log`
--
ALTER TABLE `login_log`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user_invitation`
--
ALTER TABLE `user_invitation`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `company`
--
ALTER TABLE `company`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `popularity`
--
ALTER TABLE `popularity`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
    ADD PRIMARY KEY (`id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
    ADD CONSTRAINT `usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON
        DELETE
        NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user_invitation`
--
ALTER TABLE `user_invitation`
    ADD CONSTRAINT `invitation_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON
        DELETE
        NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `invitation_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON
DELETE
NO ACTION ON
UPDATE NO ACTION;

--
-- AUTO_INCREMENT de la tabla `nombredeevento_migraciones`
--
ALTER TABLE `migrations`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

