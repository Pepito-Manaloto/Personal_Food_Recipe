-- MySQL dump 10.16  Distrib 10.1.10-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: personal_food_recipe
-- ------------------------------------------------------
-- Server version   10.1.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `personal_food_recipe`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `personal_food_recipe` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `personal_food_recipe`;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `passwd` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredients` (
  `recipe_id` int(10) unsigned NOT NULL,
  `quantity` decimal(6,3) DEFAULT NULL,
  `measurement` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ingredient` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  KEY `title` (`recipe_id`),
  CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `instructions`
--

DROP TABLE IF EXISTS `instructions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructions` (
  `recipe_id` int(10) unsigned NOT NULL,
  `instruction` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  KEY `title` (`recipe_id`),
  CONSTRAINT `instructions_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `price_list`
--

DROP TABLE IF EXISTS `price_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price_list` (
  `ingredient` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `quantity` int(10) unsigned DEFAULT NULL,
  `measurement` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` float DEFAULT NULL,
  `author` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ingredient`),
  KEY `FK_price_list_1` (`author`),
  CONSTRAINT `FK_price_list_1` FOREIGN KEY (`author`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `preparation_time` smallint(5) unsigned NOT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servings` tinyint(3) unsigned NOT NULL,
  `author` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datein` datetime NOT NULL,
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_recipe_1` (`author`),
  KEY `FK_recipe_2` (`category_id`),
  CONSTRAINT `FK_recipe_1` FOREIGN KEY (`author`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_recipe_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'personal_food_recipe'
--
/*!50003 DROP FUNCTION IF EXISTS `strSplit` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(x varchar(10000), delim varchar(12), pos int) RETURNS varchar(500) CHARSET latin1
    DETERMINISTIC
BEGIN

   RETURN replace( substring( substring_index(x, delim, pos) , length( substring_index(x, delim, pos - 1) ) + 1 ), delim, '');

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `add_recipe` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_recipe`(in ptitle varchar(50), in pcategory varchar(25), in ppreparation_time smallint,
                            in pdescription varchar(300), in pservings tinyint, in pauthor varchar(30), in quantities_array varchar(300),
                            in measurements_array varchar(500), in ingredients_array varchar(1000), in comments_array varchar(2000),
                            in ingredients_count int, in instructions_array varchar(10000), in instructions_count int )
BEGIN

  DECLARE tmp_quantity decimal(6,3);
  DECLARE tmp_measurement varchar(15);
  DECLARE tmp_ingredients varchar(50);
  DECLARE tmp_comments varchar(100);
  DECLARE tmp_instructions varchar(500);
  DECLARE tmp_recipe_id int;
  DECLARE counter int default 0;

  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
  BEGIN
    GET DIAGNOSTICS CONDITION 1
    @p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT;
    SELECT @p1 as RETURNED_SQLSTATE  , @p2 as MESSAGE_TEXT;

    ROLLBACK;
  END;

  START TRANSACTION;

    INSERT INTO recipe(title,category_id,preparation_time,description,servings,author,datein, last_updated) VALUES(ptitle,(SELECT id FROM CATEGORIES WHERE name = pcategory),ppreparation_time,pdescription,pservings,pauthor,NOW(),NOW());
    SELECT id FROM recipe WHERE title = ptitle INTO tmp_recipe_id;

    ingredients_loop: LOOP

      SET counter = counter + 1;

      SELECT strSplit(quantities_array,'|',counter) INTO tmp_quantity;
      SELECT strSplit(measurements_array,'|',counter) INTO tmp_measurement;
      SELECT strSplit(ingredients_array,'|',counter) INTO tmp_ingredients;
      SELECT strSplit(comments_array,'|',counter) INTO tmp_comments;

      INSERT INTO ingredients(recipe_id,quantity,measurement,ingredient,comment_) VALUES(tmp_recipe_id,tmp_quantity,tmp_measurement,tmp_ingredients,tmp_comments);

      IF(counter = ingredients_count) THEN
        LEAVE ingredients_loop;
      END IF;

    END LOOP ingredients_loop;

    SET counter = 0;

    instructions_loop: LOOP

      SET counter = counter + 1;

      SELECT strSplit(instructions_array,'|',counter) INTO tmp_instructions;

      INSERT INTO instructions(recipe_id,instruction) VALUES(tmp_recipe_id,tmp_instructions);

      IF(counter = instructions_count) THEN
        LEAVE instructions_loop;
      END IF;

    END LOOP instructions_loop;

  COMMIT;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `add_user` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_user`(in usr varchar(30), in pw varchar(35))
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
  BEGIN
    ROLLBACK;
  END;

  START TRANSACTION;

    INSERT INTO account(username,passwd) VALUES( usr,SHA2(pw,256) );

  COMMIT;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `delete_recipe` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_recipe`( in ptitle varchar(50), in pauthor varchar(30) )
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
  BEGIN
    ROLLBACK;
  END;

  START TRANSACTION;

    DELETE FROM recipe WHERE title = ptitle AND author = pauthor;

  COMMIT;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `edit_user` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_user`(in oldUsername varchar(30), in newUsername varchar(30),  in pw varchar(35))
BEGIN

  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
  BEGIN
    ROLLBACK;
  END;

  START TRANSACTION;

    IF( pw like "" ) THEN
      UPDATE account SET username = newUsername WHERE username = oldUsername;
    ELSE
      UPDATE account SET username = newUsername, passwd = SHA2(pw,256) WHERE username = oldUsername;

    END IF;

  COMMIT;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_all_recipe_title` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_recipe_title`(IN plast_updated DATETIME, OUT recently_added_count INT)
BEGIN
  SELECT COUNT(*) FROM recipe WHERE last_updated > (pLast_updated  - INTERVAL 30 MINUTE) INTO recently_added_count;
  SELECT title FROM recipe ORDER BY title ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_categories` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_categories`()
begin
select * from categories;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_recipe` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recipe`(in ptitle varchar(50))
BEGIN

  SELECT c.name as category, r.preparation_time, r.description, r.servings FROM recipe r, categories c WHERE r.title = Ptitle AND r.category_id = c.id;

  SELECT quantity, measurement, ingredient,comment_ FROM ingredients INNER JOIN recipe ON recipe_id = id WHERE title = ptitle;

  SELECT instruction FROM instructions INNER JOIN recipe ON recipe_id = id WHERE title = ptitle;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `get_recipe_count` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recipe_count`(in pauthor varchar(30), in pcategory varchar(25))
BEGIN

  IF (pauthor LIKE "") THEN
    IF (pcategory LIKE "All") THEN
      SELECT COUNT(title) FROM recipe;
    ELSE
      SELECT COUNT(r.title) FROM recipe r, categories c WHERE c.id = r.category_id AND c.name = pcategory;
    END IF;
  ELSE
    IF (pcategory LIKE "All") THEN
      SELECT COUNT(title) FROM recipe WHERE author = pauthor;
    ELSE
      SELECT COUNT(r.title) FROM recipe r, categories c WHERE r.author = pauthor AND c.id = r.category_id AND c.name = pcategory;
    END IF;
  END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `show_all_recipe` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_all_recipe`( in pcategory varchar(25), in orderFlag varchar(10), in recipeLimit int, in recipeOffset int )
BEGIN

  IF ( pcategory LIKE "All" ) THEN
    IF ( orderFlag LIKE "Asc" ) THEN
        SELECT r.title, c.name as category, r.description, r.author FROM recipe r, categories c WHERE c.id = r.category_id ORDER BY r.title ASC LIMIT recipeLimit OFFSET recipeOffset;
    ELSEIF ( orderFlag LIKE "Desc") THEN
        SELECT r.title, c.name as category, r.description, r.author FROM recipe r, categories c WHERE c.id = r.category_id ORDER BY r.title DESC LIMIT recipeLimit OFFSET recipeOffset;
    END IF;
  ELSE
    IF ( orderFlag LIKE "Asc") THEN
        SELECT r.title, c.name as category, r.description, r.author FROM recipe r, categories c WHERE c.id = r.category_id AND c.name = pcategory ORDER BY r.title ASC LIMIT recipeLimit OFFSET recipeOffset;
    ELSEIF ( orderFlag LIKE "Desc" ) THEN
        SELECT r.title, c.name as category, r.description, r.author FROM recipe r, categories c WHERE c.id = r.category_id AND c.name = pcategory ORDER BY r.title DESC LIMIT recipeLimit OFFSET recipeOffset;
    END IF;
  END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `show_recipe` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_recipe`( in pauthor varchar(30), in pcategory varchar(25), in orderFlag varchar(10), in recipeLimit int, in recipeOffset int )
BEGIN

  IF ( pcategory LIKE "All" ) THEN
    IF ( orderFlag LIKE "Asc" ) THEN
        SELECT r.title, c.name as category, r.description FROM recipe r, categories c WHERE r.author = pauthor AND c.id = r.category_id ORDER BY r.title ASC LIMIT recipeLimit OFFSET recipeOffset;
    ELSEIF ( orderFlag LIKE "Desc") THEN
        SELECT r.title, c.name as category, r.description FROM recipe r, categories c WHERE r.author = pauthor AND c.id = r.category_id ORDER BY r.title DESC LIMIT recipeLimit OFFSET recipeOffset;
    END IF;
  ELSE
    IF ( orderFlag LIKE "Asc") THEN
        SELECT r.title, c.name as category, r.description FROM recipe r, categories c WHERE r.author = pauthor AND c.id = r.category_id AND c.name = pcategory ORDER BY title ASC LIMIT recipeLimit OFFSET recipeOffset;
    ELSEIF ( orderFlag LIKE "Desc" ) THEN
        SELECT r.title, c.name as category, r.description FROM recipe r, categories c WHERE r.author = pauthor AND c.id = r.category_id AND c.name = pcategory ORDER BY title DESC LIMIT recipeLimit OFFSET recipeOffset;
    END IF;
  END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `user_login` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `user_login`(in usr varchar(30), in pw CHAR(64))
BEGIN

  SELECT COUNT(*) FROM account WHERE BINARY username = usr AND passwd = SHA2(pw, 256);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-21 12:24:16
