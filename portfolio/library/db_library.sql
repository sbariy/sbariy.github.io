/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : db_library

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-06-15 01:55:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pages` varchar(255) NOT NULL,
  `publication_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_id` (`publication_id`) USING BTREE,
  CONSTRAINT `article_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('4', 'Очередная', '12-63', '3');
INSERT INTO `article` VALUES ('5', 'Функциональный язык - а какой именно?', '11-13', '8');
INSERT INTO `article` VALUES ('6', 'Начала программирования на Рефале', '13-21', '8');
INSERT INTO `article` VALUES ('7', 'Пример: синтаксический анализ выражений языка Рефал', '21-24', '8');
INSERT INTO `article` VALUES ('8', 'Дополнительные возможности', '24-25', '8');
INSERT INTO `article` VALUES ('9', 'Трассировщик', '25-27', '8');
INSERT INTO `article` VALUES ('10', 'Диалекты', '27-28', '8');
INSERT INTO `article` VALUES ('11', 'Достоинства и недочёты', '29-31', '8');
INSERT INTO `article` VALUES ('12', 'Перспективы применения и развития', '31-33', '8');

-- ----------------------------
-- Table structure for author
-- ----------------------------
DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `initials` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of author
-- ----------------------------
INSERT INTO `author` VALUES ('2', 'Василий');
INSERT INTO `author` VALUES ('3', 'Никитин');
INSERT INTO `author` VALUES ('15', 'Никитин');
INSERT INTO `author` VALUES ('20', 'Пушкин А.С.');
INSERT INTO `author` VALUES ('21', 'Банчев Б.');
INSERT INTO `author` VALUES ('22', 'Вознюк А.');
INSERT INTO `author` VALUES ('23', 'Валкин Л.');
INSERT INTO `author` VALUES ('24', 'Залива В.');
INSERT INTO `author` VALUES ('25', 'Ключников И.');
INSERT INTO `author` VALUES ('26', 'Смирнов О.');
INSERT INTO `author` VALUES ('27', 'Чуковский В.');
INSERT INTO `author` VALUES ('28', 'Шпак А.');
INSERT INTO `author` VALUES ('29', 'Щербин В.');
INSERT INTO `author` VALUES ('30', 'Ветряков К.');
INSERT INTO `author` VALUES ('31', 'Бамоев Д.');
INSERT INTO `author` VALUES ('32', 'Лермонтов М.');
INSERT INTO `author` VALUES ('33', 'Чёрный А.');
INSERT INTO `author` VALUES ('34', 'Страуструп Б.');
INSERT INTO `author` VALUES ('35', 'Гоголь Н.');
INSERT INTO `author` VALUES ('36', 'Блок С.');
INSERT INTO `author` VALUES ('38', 'Крылов И.');
INSERT INTO `author` VALUES ('40', 'Роберт Лафоре');

-- ----------------------------
-- Table structure for author_publication
-- ----------------------------
DROP TABLE IF EXISTS `author_publication`;
CREATE TABLE `author_publication` (
  `publication_id` int(11) unsigned NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`publication_id`,`author_id`),
  KEY `id_author` (`author_id`),
  CONSTRAINT `author_publication_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `author_publication_ibfk_3` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of author_publication
-- ----------------------------
INSERT INTO `author_publication` VALUES ('19', '20');
INSERT INTO `author_publication` VALUES ('8', '21');
INSERT INTO `author_publication` VALUES ('15', '21');
INSERT INTO `author_publication` VALUES ('8', '22');
INSERT INTO `author_publication` VALUES ('15', '22');
INSERT INTO `author_publication` VALUES ('8', '23');
INSERT INTO `author_publication` VALUES ('14', '23');
INSERT INTO `author_publication` VALUES ('8', '24');
INSERT INTO `author_publication` VALUES ('8', '30');
INSERT INTO `author_publication` VALUES ('8', '31');
INSERT INTO `author_publication` VALUES ('12', '34');
INSERT INTO `author_publication` VALUES ('19', '35');
INSERT INTO `author_publication` VALUES ('19', '38');
INSERT INTO `author_publication` VALUES ('20', '40');

-- ----------------------------
-- Table structure for bookcase
-- ----------------------------
DROP TABLE IF EXISTS `bookcase`;
CREATE TABLE `bookcase` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bookcase` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bookcase
-- ----------------------------
INSERT INTO `bookcase` VALUES ('1', '1');
INSERT INTO `bookcase` VALUES ('2', '2');
INSERT INTO `bookcase` VALUES ('3', '3');
INSERT INTO `bookcase` VALUES ('4', '4');

-- ----------------------------
-- Table structure for bookshelf
-- ----------------------------
DROP TABLE IF EXISTS `bookshelf`;
CREATE TABLE `bookshelf` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bookshelf` int(10) unsigned NOT NULL,
  `bookcase_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bookcase_id` (`bookcase_id`),
  CONSTRAINT `bookshelf_ibfk_1` FOREIGN KEY (`bookcase_id`) REFERENCES `bookcase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bookshelf
-- ----------------------------
INSERT INTO `bookshelf` VALUES ('10', '1', '1');
INSERT INTO `bookshelf` VALUES ('11', '2', '1');
INSERT INTO `bookshelf` VALUES ('14', '3', '1');
INSERT INTO `bookshelf` VALUES ('15', '4', '1');
INSERT INTO `bookshelf` VALUES ('16', '1', '2');
INSERT INTO `bookshelf` VALUES ('17', '2', '2');
INSERT INTO `bookshelf` VALUES ('18', '1', '3');
INSERT INTO `bookshelf` VALUES ('19', '2', '3');
INSERT INTO `bookshelf` VALUES ('20', '3', '3');
INSERT INTO `bookshelf` VALUES ('21', '1', '4');
INSERT INTO `bookshelf` VALUES ('22', '2', '4');
INSERT INTO `bookshelf` VALUES ('23', '3', '4');
INSERT INTO `bookshelf` VALUES ('24', '4', '4');
INSERT INTO `bookshelf` VALUES ('25', '5', '4');

-- ----------------------------
-- Table structure for cycle
-- ----------------------------
DROP TABLE IF EXISTS `cycle`;
CREATE TABLE `cycle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `duration` int(10) unsigned NOT NULL,
  `year_adoption` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cycle
-- ----------------------------
INSERT INTO `cycle` VALUES ('1', 'Межспециальные дисциплины', '5', '2014');
INSERT INTO `cycle` VALUES ('2', 'Обще гуманитарные и социально-экономические дисциплины', '12', '2006');
INSERT INTO `cycle` VALUES ('3', 'Обще математические и естественнонаучные дисциплины', '5', '2014');
INSERT INTO `cycle` VALUES ('4', 'Общепрофессиональные дисциплины', '2', '2016');
INSERT INTO `cycle` VALUES ('5', 'Прочие', '6', '2014');
INSERT INTO `cycle` VALUES ('6', 'Религия', '5', '2016');
INSERT INTO `cycle` VALUES ('7', 'Специальные дисциплины', '5', '2012');
INSERT INTO `cycle` VALUES ('8', 'Новейший цикл', '8', '2009');

-- ----------------------------
-- Table structure for discipline
-- ----------------------------
DROP TABLE IF EXISTS `discipline`;
CREATE TABLE `discipline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of discipline
-- ----------------------------
INSERT INTO `discipline` VALUES ('2', 'Адвокатская деятельность');
INSERT INTO `discipline` VALUES ('3', 'Административное право');
INSERT INTO `discipline` VALUES ('4', 'Администрирование ИС');
INSERT INTO `discipline` VALUES ('5', 'Актуальные вопросы экономики, финансов и управления');
INSERT INTO `discipline` VALUES ('6', 'Актуальные проблемы гражданского права');
INSERT INTO `discipline` VALUES ('7', 'Актуальные проблемы теории государства и права');
INSERT INTO `discipline` VALUES ('8', 'Анализ деятельности коммерческого банка');
INSERT INTO `discipline` VALUES ('9', 'Анализ и аудит в страховых организациях');
INSERT INTO `discipline` VALUES ('10', 'Анализ и аудит на биржах в ИИ во внебюджетных фондах');
INSERT INTO `discipline` VALUES ('11', 'Анализ финансовой отчетности');
INSERT INTO `discipline` VALUES ('12', 'Анализ хозяйственной деятельности');
INSERT INTO `discipline` VALUES ('13', 'Антикризисное управление');
INSERT INTO `discipline` VALUES ('14', 'Арбитражное право');
INSERT INTO `discipline` VALUES ('15', 'Арбитражный процесс');
INSERT INTO `discipline` VALUES ('16', 'Аудит');
INSERT INTO `discipline` VALUES ('17', 'База данных');
INSERT INTO `discipline` VALUES ('18', 'Банковские услуг');
INSERT INTO `discipline` VALUES ('19', 'Банковский маркетинг');
INSERT INTO `discipline` VALUES ('20', 'Банковское право');
INSERT INTO `discipline` VALUES ('21', 'БЖД');
INSERT INTO `discipline` VALUES ('22', 'Бухгалтерская (финансовая отчетность)');
INSERT INTO `discipline` VALUES ('23', 'Бухгалтерская отчетность');
INSERT INTO `discipline` VALUES ('24', 'Бухгалтерский управленческий учет');
INSERT INTO `discipline` VALUES ('25', 'Бухгалтерский учет');
INSERT INTO `discipline` VALUES ('26', 'Бухгалтерский учет в коммерческом банке');
INSERT INTO `discipline` VALUES ('27', 'Бухгалтерский учет в кредитной организации');
INSERT INTO `discipline` VALUES ('28', 'Бухгалтерский учет в страховых организациях');
INSERT INTO `discipline` VALUES ('29', 'Бухгалтерский учет в строительных организациях');
INSERT INTO `discipline` VALUES ('30', 'Бухгалтерский учет в торговле');
INSERT INTO `discipline` VALUES ('31', 'Бухгалтерский учет в туристических фирмах');
INSERT INTO `discipline` VALUES ('32', 'Бухгалтерский учет и анализ');
INSERT INTO `discipline` VALUES ('33', 'Бухгалтерский учет на ПЭВМ');
INSERT INTO `discipline` VALUES ('34', 'Бухгалтерский финансовый учет');
INSERT INTO `discipline` VALUES ('35', 'Бухгалтерское дело');
INSERT INTO `discipline` VALUES ('36', 'Бюджетная система');
INSERT INTO `discipline` VALUES ('37', 'Бюджетный учет и отчетность');
INSERT INTO `discipline` VALUES ('38', 'Валютные операции и валютные регулирования');
INSERT INTO `discipline` VALUES ('39', 'Внутрифирменные стандарты аудита');
INSERT INTO `discipline` VALUES ('40', 'Вычислительные системы, сети и телекоммуникации');
INSERT INTO `discipline` VALUES ('41', 'Государственные и муниципальные финансы');
INSERT INTO `discipline` VALUES ('42', 'Гражданский процесс');
INSERT INTO `discipline` VALUES ('43', 'Гражданское право');
INSERT INTO `discipline` VALUES ('44', 'Деловое общение');
INSERT INTO `discipline` VALUES ('45', 'Деловой иностранный язык');
INSERT INTO `discipline` VALUES ('46', 'Делопроизводство');
INSERT INTO `discipline` VALUES ('47', 'Дипломное проектирование');
INSERT INTO `discipline` VALUES ('48', 'Дискретная математика');
INSERT INTO `discipline` VALUES ('49', 'ДКБ');
INSERT INTO `discipline` VALUES ('50', 'Жилищное право');
INSERT INTO `discipline` VALUES ('51', 'Защита информации');
INSERT INTO `discipline` VALUES ('52', 'Земельное право');
INSERT INTO `discipline` VALUES ('53', 'Инвестиции');
INSERT INTO `discipline` VALUES ('54', 'Инновационный анализ');
INSERT INTO `discipline` VALUES ('55', 'Инновационный менеджмент');
INSERT INTO `discipline` VALUES ('56', 'Иностранный язык (английский)');
INSERT INTO `discipline` VALUES ('57', 'Иностранный язык (профессиональный)');
INSERT INTO `discipline` VALUES ('58', 'Иностранный язык в сфере юриспруденции');
INSERT INTO `discipline` VALUES ('59', 'Иностранный язык профессионального общения');
INSERT INTO `discipline` VALUES ('60', 'Институциональная экономика');
INSERT INTO `discipline` VALUES ('61', 'Интеллектуальные ИС');
INSERT INTO `discipline` VALUES ('62', 'Интернет программирование');
INSERT INTO `discipline` VALUES ('63', 'Информатизация бухгалтерского учета');
INSERT INTO `discipline` VALUES ('64', 'Информатизация управления производством корпорации');
INSERT INTO `discipline` VALUES ('65', 'Информатика');
INSERT INTO `discipline` VALUES ('66', 'Информационная безопасность');
INSERT INTO `discipline` VALUES ('67', 'Информационное право');
INSERT INTO `discipline` VALUES ('68', 'Информационные системы в экономике');
INSERT INTO `discipline` VALUES ('69', 'Информационные системы и технологии');
INSERT INTO `discipline` VALUES ('70', 'Информационные системы расчета начисления и удержания в различных отраслях');
INSERT INTO `discipline` VALUES ('71', 'Информационные системы расчета себестоимости');
INSERT INTO `discipline` VALUES ('72', 'Информационные технологии в экономике');
INSERT INTO `discipline` VALUES ('73', 'Информационные технологии в юридической деятельности');
INSERT INTO `discipline` VALUES ('74', 'Информация маркетинговой деятельности');
INSERT INTO `discipline` VALUES ('75', 'Исследование операций и методы оптимизации');
INSERT INTO `discipline` VALUES ('76', 'История');
INSERT INTO `discipline` VALUES ('77', 'История государства и права зарубежных стран');
INSERT INTO `discipline` VALUES ('78', 'История Дагестана');
INSERT INTO `discipline` VALUES ('79', 'История отечественного государства и права России');
INSERT INTO `discipline` VALUES ('80', 'История политических и правовых учений');
INSERT INTO `discipline` VALUES ('81', 'История экономических учений');
INSERT INTO `discipline` VALUES ('82', 'ИСФУ');
INSERT INTO `discipline` VALUES ('83', 'Итоговая деловая игра по постановке БУ');
INSERT INTO `discipline` VALUES ('84', 'Клиент-серверны технологии СУБД');
INSERT INTO `discipline` VALUES ('85', 'Коммерческое право');
INSERT INTO `discipline` VALUES ('86', 'Комплексный экономический анализ хозяйственной деятельности');
INSERT INTO `discipline` VALUES ('87', 'Компьютерная графика');
INSERT INTO `discipline` VALUES ('88', 'Конкурентное право');
INSERT INTO `discipline` VALUES ('89', 'Конституционное право зарубежных стран');
INSERT INTO `discipline` VALUES ('90', 'Конституционное право РФ');
INSERT INTO `discipline` VALUES ('91', 'Контроллинг');
INSERT INTO `discipline` VALUES ('92', 'Контроль и ревизия');
INSERT INTO `discipline` VALUES ('93', 'Корпоративная и социальная ответственность');
INSERT INTO `discipline` VALUES ('94', 'Корпоративные информационные системы');
INSERT INTO `discipline` VALUES ('95', 'Корпоративные финансы');
INSERT INTO `discipline` VALUES ('96', 'Криминалистика');
INSERT INTO `discipline` VALUES ('97', 'Криминалистическая техника');
INSERT INTO `discipline` VALUES ('98', 'Криминология');
INSERT INTO `discipline` VALUES ('99', 'Лабораторный практикум по бухгалтерскому учету');
INSERT INTO `discipline` VALUES ('100', 'Латинский язык');
INSERT INTO `discipline` VALUES ('101', 'Линейная алгебра');
INSERT INTO `discipline` VALUES ('102', 'Логика');
INSERT INTO `discipline` VALUES ('103', 'Логистика');
INSERT INTO `discipline` VALUES ('104', 'Макроэкономика');
INSERT INTO `discipline` VALUES ('105', 'Маркетинг');
INSERT INTO `discipline` VALUES ('106', 'Математика');
INSERT INTO `discipline` VALUES ('107', 'Математическая экономика');
INSERT INTO `discipline` VALUES ('108', 'Математические методы и модели');
INSERT INTO `discipline` VALUES ('109', 'Математические основы ИС');
INSERT INTO `discipline` VALUES ('110', 'Математический анализ');
INSERT INTO `discipline` VALUES ('111', 'Математическое и имитационное моделирование');
INSERT INTO `discipline` VALUES ('112', 'Международное право');
INSERT INTO `discipline` VALUES ('113', 'Международное частное право');
INSERT INTO `discipline` VALUES ('114', 'Международные стандарты аудита');
INSERT INTO `discipline` VALUES ('115', 'Международные стандарты учета и финансовой отчетности');
INSERT INTO `discipline` VALUES ('116', 'Международные стандарты финансовой отчетности');
INSERT INTO `discipline` VALUES ('117', 'Менеджмент');
INSERT INTO `discipline` VALUES ('118', 'Методы оптимальных решений');
INSERT INTO `discipline` VALUES ('119', 'Микроэкономика');
INSERT INTO `discipline` VALUES ('120', 'МИР');
INSERT INTO `discipline` VALUES ('121', 'Мировая экономика и международные экономические отношения');
INSERT INTO `discipline` VALUES ('122', 'Муниципальное право');
INSERT INTO `discipline` VALUES ('123', 'Налоги и налогообложение');
INSERT INTO `discipline` VALUES ('124', 'Налоговое право');
INSERT INTO `discipline` VALUES ('125', 'Налоговые расчеты в бухгалтерском деле');
INSERT INTO `discipline` VALUES ('126', 'Налоговый менеджмент');
INSERT INTO `discipline` VALUES ('127', 'Налоговый учет');
INSERT INTO `discipline` VALUES ('128', 'Научно-исследовательская работа по дисциплине \"Актуальные вопросы экономики,управления и финансов\"');
INSERT INTO `discipline` VALUES ('129', 'Научно-исследовательская работа по дисциплине \"Финансы\"');
INSERT INTO `discipline` VALUES ('130', 'Научно-исследовательская работа по истории бухгалтерского учета, анализа и аудита');
INSERT INTO `discipline` VALUES ('131', 'Нормативные акты и документы');
INSERT INTO `discipline` VALUES ('132', 'Ораторское искусство юриста');
INSERT INTO `discipline` VALUES ('133', 'Организация деятельности коммерческого банка');
INSERT INTO `discipline` VALUES ('134', 'Основы аудита');
INSERT INTO `discipline` VALUES ('135', 'Основы научных иследований');
INSERT INTO `discipline` VALUES ('136', 'Основы педагогики');
INSERT INTO `discipline` VALUES ('137', 'Основы религии');
INSERT INTO `discipline` VALUES ('138', 'Особенности учета в торговле');
INSERT INTO `discipline` VALUES ('139', 'Особенности учета на предприятиях общественного питания');
INSERT INTO `discipline` VALUES ('140', 'Отечественная история');
INSERT INTO `discipline` VALUES ('141', 'Оценка бизнеса');
INSERT INTO `discipline` VALUES ('142', 'Оценка стоимости бизнеса');
INSERT INTO `discipline` VALUES ('143', 'П_завершающая');
INSERT INTO `discipline` VALUES ('144', 'П_ознакомительная');
INSERT INTO `discipline` VALUES ('145', 'П_ознакомительная Кафедра Финансов');
INSERT INTO `discipline` VALUES ('146', 'П_по биржевому делу');
INSERT INTO `discipline` VALUES ('147', 'П_по информатике');
INSERT INTO `discipline` VALUES ('148', 'П_по информационному менеджменту');
INSERT INTO `discipline` VALUES ('149', 'П_по налоговому учету и планированию');
INSERT INTO `discipline` VALUES ('150', 'П_по операционным системам');
INSERT INTO `discipline` VALUES ('151', 'П_по разработке Web-приложений');
INSERT INTO `discipline` VALUES ('152', 'П_по специализации');
INSERT INTO `discipline` VALUES ('153', 'П_по страхованию');
INSERT INTO `discipline` VALUES ('154', 'П_по финансовому менеджменту');
INSERT INTO `discipline` VALUES ('155', 'П_производственная');
INSERT INTO `discipline` VALUES ('156', 'П_производственная 1');
INSERT INTO `discipline` VALUES ('157', 'П_производственная 2');
INSERT INTO `discipline` VALUES ('158', 'П_производственная по БУ 1');
INSERT INTO `discipline` VALUES ('159', 'П_производственная по БУ 2');
INSERT INTO `discipline` VALUES ('160', 'П_производственная по экономике');
INSERT INTO `discipline` VALUES ('161', 'П_учебная');
INSERT INTO `discipline` VALUES ('162', 'П_учебная по организации документооборота');
INSERT INTO `discipline` VALUES ('163', 'Планирование  инвестиционной деятельности с применением прикладных программ');
INSERT INTO `discipline` VALUES ('164', 'Политология');
INSERT INTO `discipline` VALUES ('165', 'Право');
INSERT INTO `discipline` VALUES ('166', 'Право в бухгалтерском учете');
INSERT INTO `discipline` VALUES ('167', 'Право социального обеспечения');
INSERT INTO `discipline` VALUES ('168', 'Правовое государство');
INSERT INTO `discipline` VALUES ('169', 'Правовое регулирование банкротства и внешнего управления предприятием');
INSERT INTO `discipline` VALUES ('170', 'Правовое регулирование рекламной деятельности');
INSERT INTO `discipline` VALUES ('171', 'Правовое регулирование рынка ценных бумаг');
INSERT INTO `discipline` VALUES ('172', 'Правовое регулирование экономической деятельности');
INSERT INTO `discipline` VALUES ('173', 'Правовой статус субъектов');
INSERT INTO `discipline` VALUES ('174', 'Правовые основы бухгалтерского учета и аудата');
INSERT INTO `discipline` VALUES ('175', 'Правовые основы внешнеэкономической деятельности');
INSERT INTO `discipline` VALUES ('176', 'Правовые основы защиты интеллектуальной и информационной собственности');
INSERT INTO `discipline` VALUES ('177', 'Правовые основы прикладной информатики');
INSERT INTO `discipline` VALUES ('178', 'Правовые основы управления предприятием');
INSERT INTO `discipline` VALUES ('179', 'Правовые основы экономической безопасности');
INSERT INTO `discipline` VALUES ('180', 'Правозащитные органы РФ');
INSERT INTO `discipline` VALUES ('181', 'Правоохранительные органы');
INSERT INTO `discipline` VALUES ('182', 'Предпринимательское право');
INSERT INTO `discipline` VALUES ('183', 'Преступление в сфере экономики');
INSERT INTO `discipline` VALUES ('184', 'Проблемы гражданского права');
INSERT INTO `discipline` VALUES ('185', 'Проблемы Конституционного право');
INSERT INTO `discipline` VALUES ('186', 'Проблемы ТГиП');
INSERT INTO `discipline` VALUES ('187', 'Программная инженерия');
INSERT INTO `discipline` VALUES ('188', 'Программное обеспечение оценки бизнеса');
INSERT INTO `discipline` VALUES ('189', 'Проектирование информационных систем');
INSERT INTO `discipline` VALUES ('190', 'Проектный практикум');
INSERT INTO `discipline` VALUES ('191', 'Прокурорский надзор');
INSERT INTO `discipline` VALUES ('192', 'Профессиональная этика');
INSERT INTO `discipline` VALUES ('193', 'Психология');
INSERT INTO `discipline` VALUES ('194', 'Разное');
INSERT INTO `discipline` VALUES ('195', 'Разработка бизнес-приложений средствами 1С:Предприятие (Факультатив)');
INSERT INTO `discipline` VALUES ('196', 'Разработка бизнес-приложений средствами MY SAP');
INSERT INTO `discipline` VALUES ('197', 'Разработка программных приложений');
INSERT INTO `discipline` VALUES ('198', 'Реинжениринг бизнес-процессов');
INSERT INTO `discipline` VALUES ('199', 'Римское право');
INSERT INTO `discipline` VALUES ('200', 'Рынок ценных бумаг');
INSERT INTO `discipline` VALUES ('201', 'Семейное право');
INSERT INTO `discipline` VALUES ('202', 'Сетевая экономика');
INSERT INTO `discipline` VALUES ('203', 'Системная архетектура информационных систем');
INSERT INTO `discipline` VALUES ('204', 'Системный анализ');
INSERT INTO `discipline` VALUES ('205', 'Социально-экономическая география');
INSERT INTO `discipline` VALUES ('206', 'Социология');
INSERT INTO `discipline` VALUES ('207', 'Социология и психология управления');
INSERT INTO `discipline` VALUES ('208', 'Специализированные программные продукты в экономических расчетах');
INSERT INTO `discipline` VALUES ('209', 'Статистика');
INSERT INTO `discipline` VALUES ('210', 'Страхование');
INSERT INTO `discipline` VALUES ('211', 'Страховой менеджмент');
INSERT INTO `discipline` VALUES ('212', 'Судебная медицина и психиатрия');
INSERT INTO `discipline` VALUES ('213', 'Таможенное и бюджетное право');
INSERT INTO `discipline` VALUES ('214', 'Таможенное право');
INSERT INTO `discipline` VALUES ('215', 'Таможенное право Европейского Союза');
INSERT INTO `discipline` VALUES ('216', 'Таможенное регулирование и платежи');
INSERT INTO `discipline` VALUES ('217', 'Теоретические основы финансового менеджмента');
INSERT INTO `discipline` VALUES ('218', 'Теория вероятностей и математическая статистика');
INSERT INTO `discipline` VALUES ('219', 'Теория выборки и оценка рисков');
INSERT INTO `discipline` VALUES ('220', 'Теория государства и права');
INSERT INTO `discipline` VALUES ('221', 'Теория и практика правового воспитания');
INSERT INTO `discipline` VALUES ('222', 'Теория и практика экономической безопасности');
INSERT INTO `discipline` VALUES ('223', 'Теория игр');
INSERT INTO `discipline` VALUES ('224', 'Теория отраслевых рынков');
INSERT INTO `discipline` VALUES ('225', 'Теория рисков');
INSERT INTO `discipline` VALUES ('226', 'Теория систем и системный анализ');
INSERT INTO `discipline` VALUES ('227', 'Технологии нечеткого моделирования в бизнесе');
INSERT INTO `discipline` VALUES ('228', 'Трудовое право');
INSERT INTO `discipline` VALUES ('229', 'Уголовное право');
INSERT INTO `discipline` VALUES ('230', 'Уголовное право зарубежных стран');
INSERT INTO `discipline` VALUES ('231', 'Уголовно-исполнительное право');
INSERT INTO `discipline` VALUES ('232', 'Уголовный процесс');
INSERT INTO `discipline` VALUES ('233', 'Управление в социальных системах');
INSERT INTO `discipline` VALUES ('234', 'Управление денежными потоками');
INSERT INTO `discipline` VALUES ('235', 'Управление информационными ресурсами');
INSERT INTO `discipline` VALUES ('236', 'Управление информационными системами');
INSERT INTO `discipline` VALUES ('237', 'Управление финансовыми рисками');
INSERT INTO `discipline` VALUES ('238', 'Управленческий анализ в отраслях');
INSERT INTO `discipline` VALUES ('239', 'Управленческий учет');
INSERT INTO `discipline` VALUES ('240', 'Учебная практика по деловому этикету');
INSERT INTO `discipline` VALUES ('241', 'Учет внешнеэкономической деятельности');
INSERT INTO `discipline` VALUES ('242', 'Учет затрат, калькулирование и бюджетирование в отдельных отраслях производственной сфере');
INSERT INTO `discipline` VALUES ('243', 'Учет и анализ банкротств');
INSERT INTO `discipline` VALUES ('244', 'Учет и анализ на предпр в условиях антикриз управ');
INSERT INTO `discipline` VALUES ('246', 'Учет на предприятиях малого бизнеса');
INSERT INTO `discipline` VALUES ('247', 'Учет, анализ и аудит внешнеэкономической деятельности');
INSERT INTO `discipline` VALUES ('248', 'Физическая культура');
INSERT INTO `discipline` VALUES ('249', 'Философия');
INSERT INTO `discipline` VALUES ('250', 'Финансовая математика');
INSERT INTO `discipline` VALUES ('251', 'Финансовая статистика');
INSERT INTO `discipline` VALUES ('252', 'Финансовое право');
INSERT INTO `discipline` VALUES ('253', 'Финансовые рынки');
INSERT INTO `discipline` VALUES ('254', 'Финансовые рынки и институты');
INSERT INTO `discipline` VALUES ('255', 'Финансовый анализ');
INSERT INTO `discipline` VALUES ('256', 'Финансовый менеджмент');
INSERT INTO `discipline` VALUES ('257', 'Финансовый менеджмент в инвестиционных фондах');
INSERT INTO `discipline` VALUES ('258', 'Финансовый учет');
INSERT INTO `discipline` VALUES ('259', 'Финансы');
INSERT INTO `discipline` VALUES ('260', 'Численные методы');
INSERT INTO `discipline` VALUES ('261', 'Экологическое право');
INSERT INTO `discipline` VALUES ('262', 'Эконометрика');
INSERT INTO `discipline` VALUES ('263', 'Экономика');
INSERT INTO `discipline` VALUES ('264', 'Экономика и управление корпорацией');
INSERT INTO `discipline` VALUES ('265', 'Экономика труда');
INSERT INTO `discipline` VALUES ('266', 'Экономика фирмы');
INSERT INTO `discipline` VALUES ('267', 'Экономико-математические методы');
INSERT INTO `discipline` VALUES ('268', 'Экономическая и финансовая безопасность');
INSERT INTO `discipline` VALUES ('269', 'Экономическая история');
INSERT INTO `discipline` VALUES ('270', 'Экономическая теория');
INSERT INTO `discipline` VALUES ('271', 'Экономический анализ');
INSERT INTO `discipline` VALUES ('272', 'Электронная коммерция');
INSERT INTO `discipline` VALUES ('273', 'Юридическая психология');
INSERT INTO `discipline` VALUES ('275', 'Учёт и анализ экспортно-импортных операций');

-- ----------------------------
-- Table structure for discipline_cycle
-- ----------------------------
DROP TABLE IF EXISTS `discipline_cycle`;
CREATE TABLE `discipline_cycle` (
  `discipline_id` int(10) unsigned NOT NULL,
  `cycle_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`discipline_id`,`cycle_id`),
  KEY `cycle_id` (`cycle_id`),
  CONSTRAINT `discipline_cycle_ibfk_1` FOREIGN KEY (`discipline_id`) REFERENCES `discipline` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `discipline_cycle_ibfk_2` FOREIGN KEY (`cycle_id`) REFERENCES `cycle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of discipline_cycle
-- ----------------------------
INSERT INTO `discipline_cycle` VALUES ('2', '1');
INSERT INTO `discipline_cycle` VALUES ('3', '1');
INSERT INTO `discipline_cycle` VALUES ('4', '1');
INSERT INTO `discipline_cycle` VALUES ('2', '2');
INSERT INTO `discipline_cycle` VALUES ('21', '2');
INSERT INTO `discipline_cycle` VALUES ('22', '2');
INSERT INTO `discipline_cycle` VALUES ('23', '2');
INSERT INTO `discipline_cycle` VALUES ('24', '2');
INSERT INTO `discipline_cycle` VALUES ('25', '2');
INSERT INTO `discipline_cycle` VALUES ('35', '3');
INSERT INTO `discipline_cycle` VALUES ('36', '3');
INSERT INTO `discipline_cycle` VALUES ('37', '3');
INSERT INTO `discipline_cycle` VALUES ('40', '3');
INSERT INTO `discipline_cycle` VALUES ('127', '4');
INSERT INTO `discipline_cycle` VALUES ('128', '4');
INSERT INTO `discipline_cycle` VALUES ('129', '4');
INSERT INTO `discipline_cycle` VALUES ('130', '4');
INSERT INTO `discipline_cycle` VALUES ('131', '4');
INSERT INTO `discipline_cycle` VALUES ('132', '4');
INSERT INTO `discipline_cycle` VALUES ('2', '5');
INSERT INTO `discipline_cycle` VALUES ('3', '5');
INSERT INTO `discipline_cycle` VALUES ('4', '5');
INSERT INTO `discipline_cycle` VALUES ('6', '5');
INSERT INTO `discipline_cycle` VALUES ('158', '6');
INSERT INTO `discipline_cycle` VALUES ('159', '6');
INSERT INTO `discipline_cycle` VALUES ('210', '6');
INSERT INTO `discipline_cycle` VALUES ('214', '6');
INSERT INTO `discipline_cycle` VALUES ('215', '6');
INSERT INTO `discipline_cycle` VALUES ('18', '7');
INSERT INTO `discipline_cycle` VALUES ('89', '7');
INSERT INTO `discipline_cycle` VALUES ('2', '8');
INSERT INTO `discipline_cycle` VALUES ('42', '8');
INSERT INTO `discipline_cycle` VALUES ('87', '8');
INSERT INTO `discipline_cycle` VALUES ('88', '8');
INSERT INTO `discipline_cycle` VALUES ('90', '8');
INSERT INTO `discipline_cycle` VALUES ('91', '8');

-- ----------------------------
-- Table structure for publication
-- ----------------------------
DROP TABLE IF EXISTS `publication`;
CREATE TABLE `publication` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `isbn` varchar(255) DEFAULT NULL,
  `issn` varchar(255) DEFAULT NULL,
  `bbk` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `publishing_year` int(255) unsigned DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recommended` tinyint(4) NOT NULL DEFAULT '0',
  `number` int(10) unsigned DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT '0',
  `annotation` text,
  `publication_type_id` int(10) unsigned DEFAULT NULL,
  `publisher_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_type_id` (`publication_type_id`),
  KEY `publisher_id` (`publisher_id`),
  CONSTRAINT `publication_ibfk_1` FOREIGN KEY (`publication_type_id`) REFERENCES `publication_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `publication_ibfk_2` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of publication
-- ----------------------------
INSERT INTO `publication` VALUES ('1', null, '98765421', null, 'Журнал \"Наука и Жизнь\"', null, '2009-06-12', '2016-05-27 19:09:24', '0', '8', 'periodical', '', '18', '1');
INSERT INTO `publication` VALUES ('3', null, '632168413', null, 'Периодическое издание', null, '2010-07-30', '2016-05-27 19:09:24', '1', '4', 'periodical', '', '17', '15');
INSERT INTO `publication` VALUES ('6', null, '6846506854680', null, 'Простаквашино', null, '2016-06-06', '2016-05-27 19:09:24', '0', '19', 'periodical', '', '24', '16');
INSERT INTO `publication` VALUES ('7', null, '64654680054045', null, 'Газета \"Труд\"', null, '2000-11-17', '2016-05-27 19:09:24', '0', '27', 'periodical', '', null, '1');
INSERT INTO `publication` VALUES ('8', null, '20758476', null, 'Практика функционального программирования', null, '2016-06-17', '2016-05-27 19:09:24', '1', '7', 'periodical', 'Знакомство с языком Рефал полезно программисту хотя бы потому, что этот функциональный язык не похож ни на один из других — среди них он занимает особое место и по возрасту, и по происхождению, и по назначению, и по стилю. Достойно сожаления то что, несмотря на свои качества, язык не очень популярен.\r\nСтатья знакомит читателя с Рефалом. Язык так прост, что его описание почти целиком вмещается в статью — за исключением стандартных функций, которых тоже немного. Простота сама по себе — положительное качество, но читатель убедится, что оно не единственно.\r\n\r\nПомимо описания самого Рефала, представлен взгляд автора на место, достоинства и слабые стороны языка', '30', '18');
INSERT INTO `publication` VALUES ('12', '5-7989-0226-2', null, 'з 973.2-018.1c++', 'Язык программирования C++', '2008', null, '2016-05-27 22:27:14', '0', null, 'book', 'Книга написана Бьерном Страуструпом - автором языка программирования C++ - и является каноническим изложением возможностей этого языка. Помимо подробного описания собственно языка, на страницах книги вы найдете доказавшие свою эффективность подходы к решению разнообразных задач проектирования и программирования. Многочисленные примеры демонстрируют как хороший стиль программирования на С-совместимом ядре C++, так и современный объектно-ориентированный подход к созданию программных продуктов. Третье издание бестселлера было существенно переработано автором. Результатом этой переработки стала большая доступность книги для новичков. В то же время, текст обогатился сведениями и методиками программирования, которые могут оказаться полезными даже для многоопытных специалистов по C++. Не обойдены вниманием и нововведения языка: стандартная библиотека шаблонов (STL), пространства имен (namespaces), механизм идентификации типов во время выполнения (RTTI), явные приведения типов (cast-операторы) и другие. Настоящее специальное издание отличается от третьего добавлением двух новых приложений (посвященных локализации и безопасной обработке исключений средствами стандартной библиотеки), довольно многочисленными уточнениями в остальном тексте, а также исправлением множества опечаток. Книга адресована программистам, использующим в своей повседневной работе C++. Она также будет полезна преподавателям, студентам и всем, кто хочет ознакомиться с описанием языка `из первых рук`.', '30', '21');
INSERT INTO `publication` VALUES ('13', '', null, '', 'Просто издание', null, null, '2016-05-28 13:05:08', '0', null, 'book', '', '18', '2');
INSERT INTO `publication` VALUES ('14', '3106005504', null, '16-fw255e2', 'Язык программирования Python', '2008', null, '2016-06-01 21:02:01', '1', null, 'book', '', '22', '18');
INSERT INTO `publication` VALUES ('15', null, '', null, 'Газета \"Природа\"', null, '2016-06-09', '2016-06-09 23:01:07', '0', null, 'periodical', '', null, '18');
INSERT INTO `publication` VALUES ('19', null, '49868468', null, 'Газета \"Мир\"', null, '2016-06-09', '2016-06-11 20:30:53', '0', '31', 'periodical', '', '23', '2');
INSERT INTO `publication` VALUES ('20', '978-5-4237-0038-6', null, '', 'Объектно-ориентированное программирование в С++', '2015', null, '2016-06-14 00:09:29', '0', null, 'book', '', '26', '22');

-- ----------------------------
-- Table structure for publication_instance
-- ----------------------------
DROP TABLE IF EXISTS `publication_instance`;
CREATE TABLE `publication_instance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lost` tinyint(3) unsigned DEFAULT '0',
  `in_archive` tinyint(3) unsigned DEFAULT '0',
  `given` tinyint(3) unsigned DEFAULT '0',
  `price` int(10) unsigned DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publication_id` int(10) unsigned NOT NULL,
  `bookshelf_id` int(10) unsigned DEFAULT NULL,
  `discipline_id` int(10) unsigned DEFAULT NULL,
  `cycle_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_id` (`publication_id`),
  KEY `shelf_id` (`bookshelf_id`),
  KEY `discipline_id` (`discipline_id`),
  KEY `cycle_id` (`cycle_id`),
  CONSTRAINT `publication_instance_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `publication_instance_ibfk_2` FOREIGN KEY (`bookshelf_id`) REFERENCES `bookshelf` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `publication_instance_ibfk_3` FOREIGN KEY (`discipline_id`) REFERENCES `discipline` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `publication_instance_ibfk_4` FOREIGN KEY (`cycle_id`) REFERENCES `cycle` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=356 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of publication_instance
-- ----------------------------
INSERT INTO `publication_instance` VALUES ('244', '1', '0', '0', '400', '2016-05-12 09:47:51', '3', null, null, null);
INSERT INTO `publication_instance` VALUES ('257', '0', '1', '0', '125', '2016-05-12 11:29:26', '3', null, null, null);
INSERT INTO `publication_instance` VALUES ('258', '1', '0', '0', '125', '2016-05-12 11:29:26', '3', null, null, null);
INSERT INTO `publication_instance` VALUES ('262', '1', '0', '0', null, '2016-05-13 20:15:17', '3', null, null, null);
INSERT INTO `publication_instance` VALUES ('263', '1', '0', '0', null, '2016-05-13 20:15:17', '3', null, null, null);
INSERT INTO `publication_instance` VALUES ('264', '0', '1', '0', '250', '2016-05-13 23:05:20', '6', null, null, null);
INSERT INTO `publication_instance` VALUES ('265', '1', '0', '0', '250', '2016-05-13 23:05:20', '6', null, null, null);
INSERT INTO `publication_instance` VALUES ('266', '0', '1', '0', '250', '2016-05-13 23:05:20', '6', null, null, null);
INSERT INTO `publication_instance` VALUES ('269', '0', '1', '0', '525', '2016-05-19 14:17:43', '7', null, null, null);
INSERT INTO `publication_instance` VALUES ('270', '0', '1', '0', '500', '2016-05-19 14:17:43', '7', null, null, null);
INSERT INTO `publication_instance` VALUES ('271', '0', '1', '0', '500', '2016-05-19 14:26:57', '7', null, null, null);
INSERT INTO `publication_instance` VALUES ('272', '0', '1', '0', '500', '2016-05-19 14:26:57', '7', null, null, null);
INSERT INTO `publication_instance` VALUES ('279', '0', '1', '0', '50', '2016-05-21 17:04:45', '1', null, null, null);
INSERT INTO `publication_instance` VALUES ('290', '0', '0', '0', '200', '2016-05-26 14:03:08', '8', '10', '2', '2');
INSERT INTO `publication_instance` VALUES ('291', '1', '0', '0', '350', '2016-05-26 14:03:08', '8', null, null, null);
INSERT INTO `publication_instance` VALUES ('292', '0', '1', '0', '200', '2016-05-26 14:03:08', '8', null, null, null);
INSERT INTO `publication_instance` VALUES ('293', '1', '0', '0', '200', '2016-05-26 14:03:08', '8', null, null, null);
INSERT INTO `publication_instance` VALUES ('295', '1', '0', '0', '1040', '2016-05-29 20:10:36', '8', null, null, null);
INSERT INTO `publication_instance` VALUES ('296', '1', '0', '0', '1020', '2016-05-29 20:10:36', '8', null, null, null);
INSERT INTO `publication_instance` VALUES ('297', '0', '0', '0', null, '2016-05-31 22:26:40', '1', '19', '40', '3');
INSERT INTO `publication_instance` VALUES ('298', '0', '0', '0', null, '2016-06-02 20:32:02', '1', null, null, null);
INSERT INTO `publication_instance` VALUES ('299', '0', '1', '0', null, '2016-06-02 23:16:08', '8', null, '2', '1');
INSERT INTO `publication_instance` VALUES ('300', '0', '1', '0', null, '2016-06-02 23:16:08', '8', null, '2', '2');
INSERT INTO `publication_instance` VALUES ('302', '0', '1', '0', null, '2016-06-02 23:17:41', '8', null, '35', '3');
INSERT INTO `publication_instance` VALUES ('309', '0', '0', '0', '100', '2016-06-06 17:33:40', '3', '16', '2', '2');
INSERT INTO `publication_instance` VALUES ('310', '0', '0', '0', '100', '2016-06-06 17:33:40', '3', '16', '2', '2');
INSERT INTO `publication_instance` VALUES ('311', '0', '0', '0', '100', '2016-06-06 17:33:49', '3', '16', '2', '2');
INSERT INTO `publication_instance` VALUES ('312', '0', '0', '0', '100', '2016-06-06 17:33:49', '3', '16', '2', '2');
INSERT INTO `publication_instance` VALUES ('313', '0', '0', '0', '100', '2016-06-06 17:33:49', '3', '16', '2', '2');
INSERT INTO `publication_instance` VALUES ('314', '0', '0', '0', '200', '2016-06-06 20:01:59', '3', '18', '35', '3');
INSERT INTO `publication_instance` VALUES ('315', '0', '0', '0', '200', '2016-06-06 20:01:59', '3', '18', '35', '3');
INSERT INTO `publication_instance` VALUES ('316', '1', '0', '0', '200', '2016-06-06 20:01:59', '3', null, '35', '3');
INSERT INTO `publication_instance` VALUES ('317', '0', '0', '0', '25', '2016-06-07 12:51:42', '7', '16', '21', '2');
INSERT INTO `publication_instance` VALUES ('318', '0', '0', '0', '25', '2016-06-07 12:51:42', '7', '16', '21', '2');
INSERT INTO `publication_instance` VALUES ('319', '0', '0', '0', '250', '2016-06-07 13:51:58', '12', '14', '127', '4');
INSERT INTO `publication_instance` VALUES ('320', '0', '0', '0', '350', '2016-06-07 13:51:58', '12', '16', '127', '4');
INSERT INTO `publication_instance` VALUES ('321', '0', '0', '0', '250', '2016-06-07 13:51:58', '12', '14', '127', '4');
INSERT INTO `publication_instance` VALUES ('322', '0', '1', '0', '650', '2016-06-07 18:50:36', '14', null, '21', '2');
INSERT INTO `publication_instance` VALUES ('323', '0', '1', '0', '650', '2016-06-07 18:50:36', '14', null, '21', '2');
INSERT INTO `publication_instance` VALUES ('324', '0', '1', '0', '650', '2016-06-07 18:50:59', '14', null, '21', '2');
INSERT INTO `publication_instance` VALUES ('325', '0', '1', '0', '650', '2016-06-07 18:50:59', '14', null, '21', '2');
INSERT INTO `publication_instance` VALUES ('326', '0', '0', '0', '250', '2016-06-07 18:52:59', '13', '17', '2', '2');
INSERT INTO `publication_instance` VALUES ('327', '0', '0', '0', '800', '2016-06-08 11:20:01', '12', null, '3', '1');
INSERT INTO `publication_instance` VALUES ('328', '0', '0', '0', '800', '2016-06-08 11:20:02', '12', null, '3', '1');
INSERT INTO `publication_instance` VALUES ('329', '0', '0', '0', '800', '2016-06-08 11:20:02', '12', null, '3', '1');
INSERT INTO `publication_instance` VALUES ('330', '0', '0', '0', '800', '2016-06-08 11:20:02', '12', null, '3', '1');
INSERT INTO `publication_instance` VALUES ('331', '0', '0', '0', '800', '2016-06-08 11:20:02', '12', null, '3', '1');
INSERT INTO `publication_instance` VALUES ('332', '0', '1', '0', '25', '2016-06-09 23:01:43', '15', null, '21', '2');
INSERT INTO `publication_instance` VALUES ('333', '0', '1', '0', '25', '2016-06-09 23:01:43', '15', null, '21', '2');
INSERT INTO `publication_instance` VALUES ('334', '0', '1', '0', '25', '2016-06-09 23:01:43', '15', null, '21', '2');
INSERT INTO `publication_instance` VALUES ('335', '0', '1', '0', '25', '2016-06-09 23:01:43', '15', null, '21', '2');
INSERT INTO `publication_instance` VALUES ('336', '0', '1', '0', '25', '2016-06-09 23:01:43', '15', null, '21', '2');
INSERT INTO `publication_instance` VALUES ('337', '0', '1', '0', '15', '2016-06-11 21:44:14', '15', null, '127', '4');
INSERT INTO `publication_instance` VALUES ('338', '0', '1', '0', '15', '2016-06-11 21:44:14', '15', null, '127', '4');
INSERT INTO `publication_instance` VALUES ('339', '0', '1', '0', '15', '2016-06-11 21:44:14', '15', null, '127', '4');
INSERT INTO `publication_instance` VALUES ('340', '0', '1', '0', '150', '2016-06-11 21:45:14', '8', null, '127', '4');
INSERT INTO `publication_instance` VALUES ('341', '0', '1', '0', '150', '2016-06-11 21:45:14', '8', null, '127', '4');
INSERT INTO `publication_instance` VALUES ('342', '0', '1', '0', '150', '2016-06-11 21:45:14', '8', null, '127', '4');
INSERT INTO `publication_instance` VALUES ('343', '0', '1', '0', '150', '2016-06-11 21:45:32', '8', null, '127', '4');
INSERT INTO `publication_instance` VALUES ('344', '0', '1', '0', '150', '2016-06-11 21:45:32', '8', null, '127', '4');
INSERT INTO `publication_instance` VALUES ('345', '0', '1', '0', '150', '2016-06-11 21:45:32', '8', null, '127', '4');
INSERT INTO `publication_instance` VALUES ('346', '0', '0', '0', '25', '2016-06-11 21:50:52', '19', '18', '2', '1');
INSERT INTO `publication_instance` VALUES ('347', '0', '0', '0', '25', '2016-06-11 21:50:52', '19', '18', '2', '1');
INSERT INTO `publication_instance` VALUES ('348', '0', '1', '0', '750', '2016-06-12 00:20:03', '14', null, '3', '1');
INSERT INTO `publication_instance` VALUES ('349', '0', '1', '0', '750', '2016-06-12 00:20:03', '14', null, '3', '1');
INSERT INTO `publication_instance` VALUES ('350', '0', '1', '0', '750', '2016-06-12 00:20:48', '14', null, '3', '1');
INSERT INTO `publication_instance` VALUES ('351', '0', '0', '0', '250', '2016-06-12 00:54:30', '19', '16', '2', '2');
INSERT INTO `publication_instance` VALUES ('352', '0', '0', '0', '685', '2016-06-12 11:40:08', '12', '16', '2', '2');
INSERT INTO `publication_instance` VALUES ('353', '0', '0', '0', '685', '2016-06-12 11:40:08', '12', '16', '23', '2');
INSERT INTO `publication_instance` VALUES ('354', '0', '0', '0', '680', '2016-06-13 21:12:16', '8', '10', '2', '1');
INSERT INTO `publication_instance` VALUES ('355', '0', '0', '0', '1025', '2016-06-13 21:12:16', '8', '10', '2', '1');

-- ----------------------------
-- Table structure for publication_type
-- ----------------------------
DROP TABLE IF EXISTS `publication_type`;
CREATE TABLE `publication_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of publication_type
-- ----------------------------
INSERT INTO `publication_type` VALUES ('17', 'Лекции');
INSERT INTO `publication_type` VALUES ('18', 'Монография');
INSERT INTO `publication_type` VALUES ('19', 'Научно-практические издания');
INSERT INTO `publication_type` VALUES ('20', 'Научные издания');
INSERT INTO `publication_type` VALUES ('22', 'Официальные издания');
INSERT INTO `publication_type` VALUES ('23', 'Справочные издания');
INSERT INTO `publication_type` VALUES ('24', 'Стихи');
INSERT INTO `publication_type` VALUES ('25', 'Тесты');
INSERT INTO `publication_type` VALUES ('26', 'Учебник+Практикум');
INSERT INTO `publication_type` VALUES ('27', 'Учебники');
INSERT INTO `publication_type` VALUES ('28', 'Учебно-методические пособия');
INSERT INTO `publication_type` VALUES ('29', 'Учебно-методический комплекс');
INSERT INTO `publication_type` VALUES ('30', 'Учебно-практические пособия');
INSERT INTO `publication_type` VALUES ('31', 'Учебные пособия');

-- ----------------------------
-- Table structure for publisher
-- ----------------------------
DROP TABLE IF EXISTS `publisher`;
CREATE TABLE `publisher` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of publisher
-- ----------------------------
INSERT INTO `publisher` VALUES ('1', 'Книжный Дом \"Азбукварик Групп\"');
INSERT INTO `publisher` VALUES ('2', 'Издательство \"Прибой\"');
INSERT INTO `publisher` VALUES ('14', 'Издательство \"Мой дом\"');
INSERT INTO `publisher` VALUES ('15', 'Издательство \"Твой дом\"');
INSERT INTO `publisher` VALUES ('16', 'Издательство \"Ваш дом\"');
INSERT INTO `publisher` VALUES ('18', 'Самиздал');
INSERT INTO `publisher` VALUES ('21', 'Бином');
INSERT INTO `publisher` VALUES ('22', 'Издательство \"Питер\"');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `auth_key` (`auth_key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('5', 'admin', '$2y$13$WBA8vIbTTdWuf7KvFeRiVud.r1YvanPI1VMuZ8v5wFIyE0Qlcz4y6', '6i', 'Администратор');
