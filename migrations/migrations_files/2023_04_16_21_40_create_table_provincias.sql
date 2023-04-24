--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias`
(
    `id`   int(3) NOT NULL,
    `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla `provincias`
--

ALTER TABLE `provincias`
    ADD PRIMARY KEY (`id`);

--
-- Autonumeric id tabla `provincias`
--

ALTER TABLE `provincias`
    MODIFY `id` int (3) NOT NULL AUTO_INCREMENT;

--
-- Añadir provincias a la tabla `provincias`
--
INSERT INTO `provincias` (`name`) VALUES
('Álava'),('Albacete'),('Alicante'),('Almería'),('Asturias'),('Ávila'),('Badajoz'),('Barcelona'),('Burgos'),('Cáceres'),
('Cádiz'),('Cantabria'),('Castellón'),('Ciudad Real'),('Córdoba'),('Cuenca'),('Gerona'),('Granada'),('Guadalajara'),('Guipúzcoa'),
('Huelva'),('Huesca'),('Islas Baleares'),('Jaén'),('La Coruña'),('La Rioja'),('Las Palmas'),('León'),('Lérida'),('Lugo'),
('Madrid'),('Málaga'),('Murcia'),('Navarra'),('Orense'),('Palencia'),('Pontevedra'),('Salamanca'),('Santa Cruz de Tenerife'),
('Segovia'),('Sevilla'),('Soria'),('Tarragona'),('Teruel'),('Toledo'),('Valencia'),('Valladolid'),('Vizcaya'),('Zamora'),('Zaragoza');


--
-- Modificar tabla 'company'
--

UPDATE `company` SET `provincia`= 1;

ALTER TABLE `company` MODIFY COLUMN `provincia` int(3);

--
-- Indices para tabla `company`
--

ALTER TABLE `company`
  ADD KEY `company_provincia` (`provincia`);

--
-- foreign keys para tabla `company`
--

ALTER TABLE `company`
ADD CONSTRAINT `company_provincia` FOREIGN KEY (`provincia`) REFERENCES `provincias` (`id`) ON
    DELETE
    NO ACTION ON
    UPDATE NO ACTION;

