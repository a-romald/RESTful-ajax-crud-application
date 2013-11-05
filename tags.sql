--
-- Table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Dump table `tags`
--

INSERT INTO `tags` (`id`, `title`) VALUES
(1, 'cities'),
(2, 'boxes'),
(3, 'phones'),
(4, 'houses'),
(5, 'flats'),
(6, 'phones'),
(7, 'comps'),
(8, 'windows'),
(9, 'kitchens'),
(10, 'spoons');
