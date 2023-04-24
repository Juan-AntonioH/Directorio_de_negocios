--
-- Indices para tabla popularity
--

ALTER TABLE `popularity`
  ADD KEY `popularity_user` (`id_user`),
  ADD KEY `popularity_company` (`id_company`);

--
-- foreign keys para tabla popularity
--

ALTER TABLE `popularity`
ADD CONSTRAINT `popularity_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON
    DELETE
    NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `popularity_company` FOREIGN KEY (`id_company`) REFERENCES `company` (`id`) ON
    DELETE
    NO ACTION ON
    UPDATE NO ACTION;