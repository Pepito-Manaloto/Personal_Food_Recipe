-- MySQL dump 10.13  Distrib 5.6.11, for Win32 (x86)
--
-- Host: localhost    Database: personal_food_recipe
-- ------------------------------------------------------
-- Server version	5.6.11

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

/*!40000 DROP DATABASE IF EXISTS `personal_food_recipe`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `personal_food_recipe` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `personal_food_recipe`;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `username` varchar(30) NOT NULL DEFAULT '',
  `passwd` char(64) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES ('Aaron','1db4a0041876241916ff8b935a46b680de655e06456c77c1d2970688ea2838b9');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredients` (
  `title` varchar(50) NOT NULL,
  `quantity` decimal(6,3) DEFAULT NULL,
  `measurement` varchar(15) DEFAULT NULL,
  `ingredient` varchar(50) DEFAULT NULL,
  `comment_` varchar(100) DEFAULT '-',
  KEY `title` (`title`),
  CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`title`) REFERENCES `recipe` (`title`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredients`
--

LOCK TABLES `ingredients` WRITE;
/*!40000 ALTER TABLE `ingredients` DISABLE KEYS */;
INSERT INTO `ingredients` VALUES ('Classic Crab',2.000,'whole','crab','fresh'),('Classic Crab',75.000,'ml','canola oil','5 tablespoon'),('Classic Crab',60.000,'ml','seasame oil','4 tablespoon'),('Classic Crab',500.000,'ml','sprite or seven up','bottle'),('Classic Crab',4.000,'pieces','garlic','cloves'),('Classic Crab',4.000,'pieces','ginger','coins'),('Classic Crab',150.000,'ml','light soy sauce',''),('Classic Steak',200.000,'grams','rib-eye or tenderloin','1 inch thick'),('Classic Steak',0.000,'approximate','salt',''),('Classic Steak',0.000,'approximate','black pepper',''),('Classic Steak',0.000,'approximate','worcestershire sauce',''),('Classic Steak',2.000,'teaspoon','butter','melted'),('Chinese Steamed Fish',1.000,'whole','fish','can also be half'),('Chinese Steamed Fish',2.000,'stalks','scallion or green onion',''),('Chinese Steamed Fish',4.000,'pieces','ginger','coins'),('Chinese Steamed Fish',45.000,'ml','canola oil','3 teaspoon'),('Chinese Steamed Fish',45.000,'ml','sesame oil','3 teaspoon'),('Chinese Steamed Fish',100.000,'ml','light soy sauce',''),('Fettuccini',80.000,'grams','fettuccini or spaghetti',''),('Fettuccini',100.000,'grams','all-purpose cream',''),('Fettuccini',200.000,'grams','milk',''),('Fettuccini',1.000,'whole','white onion','small'),('Fettuccini',6.000,'cloves','garlic',''),('Fettuccini',2.000,'pieces','bottom mushroom',''),('Fettuccini',0.500,'teaspoon','rosemary','dried, crushed'),('Fettuccini',70.000,'grams','ham','flavored'),('Fettuccini',50.000,'grams','bacon',''),('Fettuccini',0.000,'approximate','parsley','fresh'),('Fettuccini',0.000,'approximate','salt',''),('Fettuccini',0.000,'approximate','black pepper',''),('Fettuccini',0.000,'approximate','parmesan',''),('Cheesecake',0.200,'cup','white sugar1','40 grams'),('Cheesecake',100.000,'grams','graham cracker','pulverzied'),('Cheesecake',70.000,'grams','butter','melted'),('Cheesecake',0.625,'cup','white sugar2','125 grams'),('Cheesecake',0.125,'teaspoon','salt',''),('Cheesecake',300.000,'grams','cream cheese',''),('Cheesecake',250.000,'grams','all-purpose cream','chilled'),('Cheesecake',0.250,'teaspoon','vanilla essence',''),('Cheesecake',75.000,'grams','pineapple juice',''),('Cheesecake',10.000,'grams','Ferna clear unflavored gelatin',''),('Cheesecake',150.000,'grams','filling','blueberry or strawberry'),('Prawn in coconut curry sauce',6.000,'pieces','shrimp or prawn','large size, deveined and shell intact'),('Prawn in coconut curry sauce',200.000,'ml','coconut milk',''),('Prawn in coconut curry sauce',0.750,'teaspoon','green curry','powder'),('Prawn in coconut curry sauce',0.750,'teaspoon','turmeric','powder'),('Prawn in coconut curry sauce',1.000,'teaspoon','fish sauce','patis'),('Prawn in coconut curry sauce',1.000,'stalk','leeks',''),('Prawn in coconut curry sauce',1.000,'whole','garlic',''),('Prawn in coconut curry sauce',1.000,'whole','white onion',''),('Prawn in coconut curry sauce',10.000,'gram','butter',''),('Prawn in coconut curry sauce',3.000,'teaspoon','citrus fruit','calamansi, lemon, or lime'),('Prawn in coconut curry sauce',0.000,'appoximate','salt',''),('Prawn in coconut curry sauce',0.000,'appoximate','black pepper',''),('Classic Lasagna',8.000,'sheets','Lasagna',''),('Classic Lasagna',25.000,'grams','butter 1',''),('Classic Lasagna',40.000,'grams','all purpose flour',''),('Classic Lasagna',1.000,'whole','onion','white or yellow, large size'),('Classic Lasagna',0.500,'piece','bay leaf','dried'),('Classic Lasagna',800.000,'ml','milk','approximate'),('Classic Lasagna',0.000,'approximate','salt',''),('Classic Lasagna',0.000,'approximate','ground pepper','black or white'),('Classic Lasagna',1.000,'whole','bell pepper','red or green, medium size'),('Classic Lasagna',0.000,'approximate','parsley','fresh, optional'),('Classic Lasagna',10.000,'grams','butter 2',''),('Classic Lasagna',1.000,'whole','garlic',''),('Classic Lasagna',250.000,'grams','ground beef','medium size'),('Classic Lasagna',0.000,'approximate','worcestershire sauce',''),('Classic Lasagna',0.000,'approximate','knorr',''),('Classic Lasagna',0.000,'approximate','rosemary',''),('Classic Lasagna',0.000,'approximate','italian seasoning',''),('Classic Lasagna',400.000,'grams','tomato sauce',''),('Classic Lasagna',25.000,'grams','sugar','white or washed'),('Classic Lasagna',0.000,'approximate','parmesan cheese',''),('Classic Lasagna',0.000,'approximate','mozzarella cheese',''),('Classic Lasagna',0.000,'approximate','cheddar cheese','');
/*!40000 ALTER TABLE `ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructions`
--

DROP TABLE IF EXISTS `instructions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructions` (
  `title` varchar(50) NOT NULL,
  `instruction` varchar(500) DEFAULT NULL,
  KEY `title` (`title`),
  CONSTRAINT `instructions_ibfk_1` FOREIGN KEY (`title`) REFERENCES `recipe` (`title`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructions`
--

LOCK TABLES `instructions` WRITE;
/*!40000 ALTER TABLE `instructions` DISABLE KEYS */;
INSERT INTO `instructions` VALUES ('Classic Crab','Dissect Crab remove internals and cut into pieces. Remove garlic and ginger skin. Slice ginger into coins.'),('Classic Crab','Heat wok, pour canola and sesame oil until smoking hot. High heat.'),('Classic Crab','Put ginger and cook for 30 seconds. Put garlic and crab pieces one by one. (Except crab shell)'),('Classic Crab','Pour light soy sauce then sprite/seven-up. Put Crab shell on top.'),('Classic Crab','Cover wok, boil for 15 minutes. Then turn to medium heat. Cook for 15 minutes.'),('Classic Crab','Glaze Crab with its sauce. Then use remaining sauce for dipping.'),('Classic Steak','Thaw meat until refrigerator temperature.'),('Classic Steak','Season each side with worcestershire sauce. Marinate in refrigerator for an hour. Then take out from refrigerator.'),('Classic Steak','Pat dry. Let it rest to room temperature. Season with salt and pepper each side. Then brush lightly with oil.'),('Classic Steak','Pre-heat pan until hot. High heat.'),('Classic Steak','Put some oil in the pan. Sear first side of the steak for 30 seconds.'),('Classic Steak','Turn steak, sear for 15 seconds. Change to meadium heat. Pour 1 teaspoon of butter. Cook for 4 minutes.'),('Classic Steak','Turn steak, pour 1 teaspoon of butter. Cook for 4 minutes. Let steak rest for 3 minutes.'),('Chinese Steamed Fish','Chop ginger into 4 coin pieces. Chop two ginger coins julienne. Finely chop stalks into small rings.'),('Chinese Steamed Fish','Place two coins inside of the fish\'s stomach. Heat steamer, bring to boil. High heat.'),('Chinese Steamed Fish','Steam fish for about 15 minutes. Drain excess water. (Cooking time depends on size of fish)'),('Chinese Steamed Fish','In a separate pan heat the two oil in high heat. Cook remaining ginger for 30 seconds then put scallions.'),('Chinese Steamed Fish','Pour light soy sauce. Cook for another 10 seconds. Then pour into fish.'),('Fettuccini','Chop onion, garlic, rosemary, mushroom, parsley, bacon, and ham. (mushroom thin slices and ham thin square slices)'),('Fettuccini','Cook bacon bits in a non-stick pan until crispy. Low heat. Set aside.'),('Fettuccini','Put oil in the pan. Turn on to high heat.'),('Fettuccini','Saute ham until ham has darker color.'),('Fettuccini','Remove ham from pan. Set aside. Turn to low heat.'),('Fettuccini','Cook onion for 6 minutes. Add mushroom, cook for 1 minute. Add garlic, cook for 2 minute. Add ham cook for 1 minutes.'),('Fettuccini','Pour all-purpose cream and milk. Simmer for 5 minutes.'),('Fettuccini','On a separate pan, put some oil and rock salt. Fill with water. Bring to boil. Cook pasta until al dente.'),('Fettuccini','Transfer pasta directly to the sauce pan. Simmer for at least 5 minutes. (If too thick add pasta water or milk)'),('Fettuccini','Season with salt, pepper, and parmesan. Lastly, garnish with bacon and parsley.'),('Cheesecake','For the crust. Combine butter, sugar1, salt, and graham cracker in a bowl. Mix evenly.'),('Cheesecake','Preheat oven to 360°F for 5 minutes.'),('Cheesecake','Place mixture in a 10-inch spring-form pan. Bake for 10 minutes. Set aside.'),('Cheesecake','For the base. Place sugar2 and cream cheese in a mixing bowl. Mix for 10 minutes at medium speed.'),('Cheesecake','Slowly add all-purpose cream(shake first) and vanilla liquid. Mix for five minutes at medium speed.'),('Cheesecake','Combine gelatin and pineapple juice. Heat in a double broiler until gelatin completely dissolve or mixture is smooth. (Stir while heating)'),('Cheesecake','Slowly add gelatin mixture at low speed. Mix for another two minutes at medium speed.'),('Cheesecake','Pour base into the crust. Level with spatula. Chill for 12 hours. Top with desired filling. Serve chilled.'),('Prawn in coconut curry sauce','Devein prawns, but keep the shell intact. Finely chop onion, garlic, and leeks(ring shape).'),('Prawn in coconut curry sauce','Heat olive oil in pan. Medium heat. Cook onion for 5 minutes. Add more olive oil if needed.'),('Prawn in coconut curry sauce','Pour 1/2 teaspoon of citrus fruit extract to each prawn. Season prawns with salt and black pepper.'),('Prawn in coconut curry sauce','Turn to medium-high heat. Add butter, garlic, curry, and turmeric powder. Cook for a minute.'),('Prawn in coconut curry sauce','Add leeks, cook for 30 seconds. Combine fish sauce and coconut milk.'),('Prawn in coconut curry sauce','Add prawns, meat side in the pan, cook for a minute. Add coconut mixture. Cook for 3 minutes or until the prawn is orange.'),('Prawn in coconut curry sauce','Turn prawns, cook for another 4 minutes or until the prawn is orange.'),('Prawn in coconut curry sauce','Move all ingredients to a plate except the sauce. Put excess water from the prawn to the pan.'),('Prawn in coconut curry sauce','Simmer until thick or put cornstarch as a thickening agent. Pour over prawns.'),('Classic Lasagna','Finely chop onion, bell pepper, rosemary, and garlic. Set Aside. (If parsley is included in the ingredient also chop)'),('Classic Lasagna','For the bechamel sauce. Heat some oil. Cook bell pepper for 5 minutes. Add onion. (medium heat)'),('Classic Lasagna','Add butter1 in the sauce pan. Cook until butter melts completely.'),('Classic Lasagna','Add flour to the pan. Stir well until flour completely combines with butter. Cook for a minute.'),('Classic Lasagna','Combine bay leaf, 1/4 of chopped onion and bell pepper. Set aside.'),('Classic Lasagna','Cook the roux in a medium heat, while slowly pouring some milk. Whisk until no more lumps. Then put bay leaf. Stir well, especially the bottom. Repeat pouring milk.'),('Classic Lasagna','Simmer for 15 to 25 minutes. Remove bay leaf. Then season with salt and pepper (optional). Set aside.'),('Classic Lasagna','For the red sauce. Season ground beef with knorr, worcestershire, black pepper, and rosemary. Marinate for at least 15 minutes.'),('Classic Lasagna','Heat some oil. Then sweat remaining onion in low heat for 10 minutes. Turn to medium heat and add garlic and butter2, cook for a minute. Turn to high heat, then add ground beef, cook until well done.'),('Classic Lasagna','Pour in tomato sauce, turn to low heat. Simmer for 5 to 10 minutes. Season with salt, pepper (pinch), Italian seasoning (pinch), and sugar. (If parsley is included in the ingredient sprinkle\nremaining chopped parsley)'),('Classic Lasagna','Cook Lasagna in a boiling water with salt and oil until al dente (Approximately 9-10 minutes). Drain, set aside.'),('Classic Lasagna','Combining ingredients. Pour some red sauce at the base of a baking pan for moisture.'),('Classic Lasagna','For layer 1 and 2. Pour red sauce, drizzle bechamel sauce, then add some parmesan and cheddar cheese. (use up all bell peppers in bechamel sauce)'),('Classic Lasagna','For layer 3. Drizzle red sauce, pour bechamel sauce.'),('Classic Lasagna','For layer 4(top). Pour remaining red sauce, drizzle remaining bechamel sauce, and grate mozzarella cheese (covering the whole\nlasagna), then add parmesan and cheddar cheese.'),('Classic Lasagna','Place baking pan into an oven. Bake until mozzarella melts.');
/*!40000 ALTER TABLE `instructions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `price_list`
--

DROP TABLE IF EXISTS `price_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price_list` (
  `ingredient` varchar(50) NOT NULL DEFAULT '',
  `quantity` int(10) unsigned DEFAULT NULL,
  `measurement` varchar(20) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `author` varchar(30) NOT NULL,
  PRIMARY KEY (`ingredient`),
  KEY `FK_price_list_1` (`author`),
  CONSTRAINT `FK_price_list_1` FOREIGN KEY (`author`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `price_list`
--

LOCK TABLES `price_list` WRITE;
/*!40000 ALTER TABLE `price_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `price_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe` (
  `title` varchar(50) NOT NULL,
  `category` varchar(20) NOT NULL,
  `preparation_time` smallint(5) unsigned NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `servings` tinyint(3) unsigned NOT NULL,
  `author` varchar(30) NOT NULL,
  PRIMARY KEY (`title`) USING BTREE,
  KEY `FK_recipe_1` (`author`),
  CONSTRAINT `FK_recipe_1` FOREIGN KEY (`author`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe`
--

LOCK TABLES `recipe` WRITE;
/*!40000 ALTER TABLE `recipe` DISABLE KEYS */;
INSERT INTO `recipe` VALUES ('Cheesecake','Dessert',60,'No bake cheesecake',16,'Aaron'),('Chinese Steamed Fish','Beef',30,'Steamed fish with soy sauce.',4,'Aaron'),('Classic Crab','Seafood',45,'Home-style crab.',4,'Aaron'),('Classic Lasagna','Pasta',120,'Four layered red and white sauce lasagna.',6,'Aaron'),('Classic Steak','Beef',75,'Typical steak',1,'Aaron'),('Fettuccini','Pasta',60,'White base creamy pasta',2,'Aaron'),('Prawn in coconut curry sauce','Seafood',35,'Creamy and aromatic flavor, not spicy.',3,'Aaron');
/*!40000 ALTER TABLE `recipe` ENABLE KEYS */;
UNLOCK TABLES;

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
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_recipe`(in ptitle varchar(50), in pcategory varchar(20), in ppreparation_time smallint,
                            in pdescription varchar(300), in pservings tinyint, in pauthor varchar(30), in quantities_array varchar(300),
                            in measurements_array varchar(500), in ingredients_array varchar(1000), in comments_array varchar(2000),
                            in ingredients_count int, in instructions_array varchar(10000), in instructions_count int )
BEGIN

  DECLARE tmp_quantity decimal(6,3);
  DECLARE tmp_measurement varchar(15);
  DECLARE tmp_ingredients varchar(50);
  DECLARE tmp_comments varchar(100);
  DECLARE tmp_instructions varchar(500);
  DECLARE counter int default 0;

  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
  BEGIN
    ROLLBACK;
  END;

  START TRANSACTION;

    /* FIRST INSERT BASIC DATA INTO RECIPE */
    INSERT INTO recipe(title,category,preparation_time,description,servings,author) VALUES(ptitle,pcategory,ppreparation_time,pdescription,pservings,pauthor);


    /* ITERATE WHLE INSERTING THE INGREDIENTS */
    ingredients_loop: LOOP

      SET counter = counter + 1;

      SELECT strSplit(quantities_array,'|',counter) INTO tmp_quantity;
      SELECT strSplit(measurements_array,'|',counter) INTO tmp_measurement;
      SELECT strSplit(ingredients_array,'|',counter) INTO tmp_ingredients;
      SELECT strSplit(comments_array,'|',counter) INTO tmp_comments;

      INSERT INTO ingredients(title,quantity,measurement,ingredient,comment_) VALUES(ptitle,tmp_quantity,tmp_measurement,tmp_ingredients,tmp_comments);

      IF(counter = ingredients_count) THEN
        LEAVE ingredients_loop;
      END IF;

    END LOOP ingredients_loop;


    /* RESET COUNTER */
    SET counter = 0;


    /* ITERATE WHILE INSERTING THE INSTRUCTIONS */
    instructions_loop: LOOP

      SET counter = counter + 1;

      SELECT strSplit(instructions_array,'|',counter) INTO tmp_instructions;

      INSERT INTO instructions(title,instruction) VALUES(ptitle,tmp_instructions);

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

  SELECT category, preparation_time, description, servings FROM recipe WHERE title = Ptitle;

  SELECT quantity, measurement, ingredient,comment_ FROM ingredients WHERE title = ptitle;

  SELECT instruction FROM instructions WHERE title = ptitle;

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recipe_count`(in pauthor varchar(30), in pcategory varchar(20))
BEGIN

  IF (pauthor LIKE "") THEN
    IF (pcategory LIKE "All") THEN
      SELECT COUNT(title) FROM recipe;
    ELSE
      SELECT COUNT(title) FROM recipe WHERE category = pcategory;
    END IF;
  ELSE
    IF (pcategory LIKE "All") THEN
      SELECT COUNT(title) FROM recipe WHERE author = pauthor;
    ELSE
      SELECT COUNT(title) FROM recipe WHERE author = pauthor AND category = pcategory;
    END IF;
  END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `show_Allrecipe` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_Allrecipe`( in pcategory varchar(20), in orderFlag varchar(10), in recipeLimit int, in recipeOffset int )
BEGIN

  IF ( pcategory LIKE "All" ) THEN
    IF ( orderFlag LIKE "Asc" ) THEN
	    SELECT title, category, description, author FROM recipe ORDER BY title ASC LIMIT recipeLimit OFFSET recipeOffset;
    ELSEIF ( orderFlag LIKE "Desc") THEN
	    SELECT title, category, description, author FROM recipe ORDER BY title DESC LIMIT recipeLimit OFFSET recipeOffset;
    END IF;
  ELSE
    IF ( orderFlag LIKE "Asc") THEN
	    SELECT title, category, description, author FROM recipe WHERE category = pcategory ORDER BY title ASC LIMIT recipeLimit OFFSET recipeOffset;
    ELSEIF ( orderFlag LIKE "Desc" ) THEN
	    SELECT title, category, description, author FROM recipe WHERE category = pcategory ORDER BY title DESC LIMIT recipeLimit OFFSET recipeOffset;
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_recipe`( in pauthor varchar(30), in pcategory varchar(20), in orderFlag varchar(10), in recipeLimit int, in recipeOffset int )
BEGIN

  IF ( pcategory LIKE "All" ) THEN
    IF ( orderFlag LIKE "Asc" ) THEN
	    SELECT title, category, description FROM recipe WHERE author = pauthor ORDER BY title ASC LIMIT recipeLimit OFFSET recipeOffset;
    ELSEIF ( orderFlag LIKE "Desc") THEN
	    SELECT title, category, description FROM recipe WHERE author = pauthor ORDER BY title DESC LIMIT recipeLimit OFFSET recipeOffset;
    END IF;
  ELSE
    IF ( orderFlag LIKE "Asc") THEN
	    SELECT title, category, description FROM recipe WHERE author = pauthor AND category = pcategory ORDER BY title ASC LIMIT recipeLimit OFFSET recipeOffset;
    ELSEIF ( orderFlag LIKE "Desc" ) THEN
	    SELECT title, category, description FROM recipe WHERE author = pauthor AND category = pcategory ORDER BY title DESC LIMIT recipeLimit OFFSET recipeOffset;
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

-- Dump completed on 2014-04-09 16:07:49
