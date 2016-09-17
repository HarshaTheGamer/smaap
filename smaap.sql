-- MySQL dump 10.13  Distrib 5.6.29, for Linux (x86_64)
--
-- Host: localhost    Database: smaap
-- ------------------------------------------------------
-- Server version	5.6.29

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
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `fid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_one` int(10) unsigned NOT NULL,
  `user_two` int(10) unsigned NOT NULL,
  `request_count` int(10) unsigned NOT NULL,
  `reject_count` int(10) unsigned NOT NULL,
  `status` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`fid`),
  KEY `friends_user_one_foreign` (`user_one`),
  KEY `friends_user_two_foreign` (`user_two`),
  CONSTRAINT `friends_user_one_foreign` FOREIGN KEY (`user_one`) REFERENCES `users` (`id`),
  CONSTRAINT `friends_user_two_foreign` FOREIGN KEY (`user_two`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` VALUES (26,14,33,1,0,'0'),(29,15,9,1,0,'1'),(33,14,9,1,0,'1'),(34,9,10,1,0,'1'),(55,10,15,1,0,'0'),(56,10,13,1,0,'1'),(57,9,13,1,0,'1'),(58,15,13,1,0,'1'),(59,15,14,1,0,'1'),(60,38,10,1,0,'1'),(61,38,9,1,0,'1'),(62,38,13,1,0,'0');
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `like_user` tinyint(1) NOT NULL,
  `anonymous_like` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (1,9,10,1,0,'2016-06-27 23:58:55','2016-06-27 23:58:55'),(2,15,10,1,0,'2016-06-27 23:59:09','2016-06-27 23:59:09'),(3,14,10,1,0,'2016-06-27 23:59:21','2016-06-27 23:59:21'),(47,10,11,1,0,'2016-06-28 05:10:33','2016-06-28 05:10:33'),(51,10,19,1,0,'2016-06-28 05:10:59','2016-06-28 05:10:59'),(77,10,16,1,0,'2016-06-28 06:13:42','2016-06-28 06:13:42'),(110,13,10,1,1,'2016-06-28 08:37:33','2016-06-28 08:37:33'),(118,10,14,1,0,NULL,NULL),(119,10,13,1,0,'2016-06-29 04:32:12','2016-06-29 04:32:12'),(120,10,17,1,1,'2016-07-01 04:37:08','2016-07-01 04:37:08'),(121,10,9,1,0,'2016-07-06 00:21:37','2016-07-06 00:21:37');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_06_04_070125_create_Zones_table',1),('2016_06_25_071443_create_likes_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('sanjivmjoshi@gmail.com','fc87245577ab72831e487cd584db10535c225378293469bf4837c4657a910f56','2016-06-07 04:42:12'),('lokesh@gmail.com','cd06a2debbd5c14a33088b7ca6325ceb0d48e77a76d3ef44939ff767c1446904','2016-06-08 00:48:40'),('admin@smaap.com','2dad15f953d1f23ac78ad9c218195b3b50c0e4a5ee2c433683dbb64dcc254950','2016-06-09 07:05:46'),('admin@smaap.com','87504f4ed3fe96b26cd28353b508ce001d962791f0b81990e4551ee9e981992e','2016-06-09 07:05:46'),('harsha.m.n1993@gmail.com','f2f20ff7f7522693d7888b99af70e449742622061eb48ae962c4609e01bf57b2','2016-06-21 00:21:40');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` bigint(20) NOT NULL,
  `profile` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `zone_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `chat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (9,'admin','admin@smaap.com','044b8c3251e83184441d67073745f10a','0000-00-00','',0,'images/admin@smaap.com.png','','Hc7I30kaSxsStaUeOAngsQrtW3Af80Zl2TvLXCfxzT4mqPZTnklgz3JKheVf','2016-06-06 04:23:24','2016-07-18 03:58:12',14960604),(10,'Harsha Vardhan','harsha.m.n1993@gmail.com','226280c5dd9b1bd4e67c72ff2c94bf1b','1990-04-01','Male',8050777709,'images/1465209466.png','','1x2XBUqV18sY2ckNNBRDch4OnfiHvjNRzirmL09WYRrFVWzOxfARYO0ckzl0','2016-06-06 04:27:32','2016-07-16 04:30:08',15010403),(11,'test','test@g.c','$2y$10$Qd02llIMm8A/0rF/ncLPAuQ/AA7L16NywqTQxXkh4NMhoC.dDqB3e','0000-00-00','',0,'default.jpg','',NULL,'2016-06-06 05:29:57','2016-06-06 05:29:57',NULL),(13,'sanjiv','sanjiv@gmail.com','226280c5dd9b1bd4e67c72ff2c94bf1b','1991-05-08','Male',1084968496496,'images/sanjiv@gmail.com.png','Virgosys','kufsJAavJHHuy9QjARqvcyiNeWIjqPw740fJd3fCwpX9tTMSL7PRUpiLEHz8','2016-06-07 03:02:15','2016-07-12 07:55:35',14975654),(14,'Yashodha.C','yash@gmail.com','226280c5dd9b1bd4e67c72ff2c94bf1b','1990-12-08','female',8762834995,'images/1465292534.jpg','','coQyth0RI7l3HIEeDdD75fbsVGv2WfPO7lejQ0q44p8dGwqJjRsCDRFGy6CK','2016-06-07 03:29:25','2016-07-18 07:53:23',14964804),(15,'imran','imran@gmail.com','226280c5dd9b1bd4e67c72ff2c94bf1b','1991-10-08','male',8762834997,'images/1465476179.gif','','u2B4hI6MU3a12MHRCBjYv3QRjB3YNek4E2jQz8Z7UjZNBVUgO6iSSsUI3FAJ','2016-06-07 03:37:36','2016-07-16 03:21:34',14960306),(16,'Vinod Yadav','vinu@gmail.com','$2y$10$mxg795vXtrIU6muSVjjEcO0GO4QwRd.6mf8wUOZWk97UrlJl2jKB.','1990-06-07','male',7893456789,'images/1465365591.jpg','','hdOVSjDmc0ZqV9sB6vicJ0hPdpxvM4tVDJNHvAzLjEFCt7W6OG9LJU0UUhzo','2016-06-07 03:51:58','2016-06-10 07:21:54',NULL),(17,'sanjeev joshi','sanjivmjoshi@gmail.com','$2y$10$uvI1OsraDQFoPyXsX8rzceOZKZUfBhwkOBjSwfcmGPfuVNswncuSC','0000-00-00','male',8762834995,'default.jpg','','67irYGsVXGXXHW0T8DLbVoZdCGAIqrUyyMj2esIXYUwmDftNcJN6c6HmyOXm','2016-06-07 04:36:18','2016-06-07 04:36:25',NULL),(18,'sanjeeb','sa@c.f','$2y$10$MUxIxVzPStxV0JyEasGJfOOjm9iH6sSukKW0rfm/ZTlFIz0DjP.7m','0000-00-00','male',8762834998,'default.jpg','','HlXjaMWkwUwMli1CNGPNcioRqirXgJfJ4YurtQLaHhdEHEZIhOxdqhnWvyHh','2016-06-07 04:41:27','2016-06-07 04:44:19',NULL),(19,'darshan','darshan@gmail.com','$2y$10$wX5RSaxz.UwbyImbKC67YupuPRBcjMSIhDAXFZ4F1vudEL77Tfkj.','0000-00-00','male',-9880667195,'default.jpg','','2RGgtArXxNiw69hsdvOL6j0Bm7JIEdnjZrlz5j2unH1CzMTGaOH7u7cs0bEt','2016-06-07 04:48:41','2016-06-07 04:48:55',NULL),(20,'sudeep','sudeep@gmail.com','$2y$10$SbZwAUelsaR9Q6jbETPnLeR3xUyqaEkyF/wq3nXwLfRyXk2QbDtjC','0000-00-00','',0,'default.jpg','','RASrKYCeKXcoxryle10aM0kMUcQHRjO49jyUzTY3KdVOJ6mVSiQpGT5tgGDf','2016-06-07 04:49:38','2016-06-07 04:49:44',NULL),(21,'kumar','kumar@gmail.com','$2y$10$zhzH/mPiV2XiE2Pl9T6w/uCECJtOKui0X9/9j7tdK2xzZWxOtd/Qq','0000-00-00','',0,'default.jpg','','hG5DYxX6jgBjLUIwi9QzdL8xaAmd569lTfFjd5b3GH9EqDpno7eukmdXfM1F','2016-06-07 04:58:16','2016-06-07 04:58:26',NULL),(22,'prashant','prashu@gmail.com','$2y$10$lnE6Ic53UMzNtvcrFpp0retnr.AxFzqD6TQfL22nyHQ0oZb1gLbP.','1997-12-05','male123',9223372036854775807,'default.jpg','','1XvQZWWcqnS7KLp6tCn8D8j71DJKx1lKl57I6TfApAXV8kKuPNrHx44lG7II','2016-06-07 05:06:46','2016-06-07 05:16:47',NULL),(23,'tagore','gyu@gmail.com','$2y$10$9V7NHp5p2QbsxN7nVwgvGeSkLauhETbBjtWtZ8UOjYhj8tNoHsZDG','0000-00-00','',0,'default.jpg','','Bj5Rjczmao5OIdkmBIxM0z94OKRIqRZMe2bxOnVIyazjbla4bRk4yeBUQbDw','2016-06-07 05:14:02','2016-06-07 05:15:22',NULL),(24,'harvar','harsha3@gmail.com','$2y$10$rDaqdQJ2TQi6kM45cfH0XOZI6I/NczKfAeWTST3uhmXLHHYUeQmGa','1990-04-01','male',341234132424,'default.jpg','','0Gx8dx4ugF8YQFa5APeD3ByfyQ94eYtTX1rBOSAlt5ymyuu53UPzvJtUo2Dl','2016-06-07 05:48:01','2016-06-07 06:21:28',NULL),(25,'Roger','r@g.c','$2y$10$r.eKK91DltlBS88OfgCozO2Wjg7Ym4Pdu/6uuM7BHKKYR4DIxTHGW','2000-06-05','male',8050777719,'default.jpg','','mAxIUUZDsrK7PhsW7S2kHAYPQ92t3u3UR9iwhhzaxEZUbzqrqQasf6YlRIXj','2016-06-07 07:37:08','2016-06-07 07:41:56',NULL),(26,'testt2','t@t.c','$2y$10$.8BbD6w4fG/CjOZqGkVgou5aUlwFmkrXxTeEP/1.GmFu08z9HLI7a','2000-06-01','female',8050777714,'default.jpg','','vNGJH4y6X45bgQwVLhsXnmePAu2G46JARzVxH3RAqQvYH2grUV6OULq3f4bD','2016-06-07 07:42:40','2016-06-07 07:51:59',NULL),(27,'lokesh yadav','lokesh@gmail.com','$2y$10$6bfP8DaLuB5CKt9fb4TO5unV7nTGIK7YDEvAD/c1Y.JycTYNO5kiC','2000-06-08','male',8970603047,'images/1465811699.gif','','IPPyQzvZXOSGg3y8ZVwrazXTukBWWl9sfVqeLgq8I5SmX4o6IBSOus12bh5U','2016-06-08 00:31:30','2016-06-14 00:26:24',NULL),(28,'pradeep','pradeep@gmail.com','$2y$10$4N68CIYEIWkZY13jGz3pSODjSidog4zIwwTHB5cCYNwMresccotQy','1990-06-07','male',876283499578899999,'default.jpg','','vmXxj6l56JDvQVRfCgoiWR6uPeg3rRQ2Uu4c4KjeVZZXARzUnjA5lPETZANk','2016-06-08 00:50:35','2016-06-08 01:05:23',NULL),(29,'sanju','sanju@gmail.com','$2y$10$y.wUPIliPq.BGHM1Wfop8.gAzkwvSq9SsZy4qx5clbN.ebzMed9V.','1991-06-05','male',8762834995,'default.jpg','','qeQiBYR1eS9nQBK1MnWarZvrGOKnfXIHbGq3YOgUcr8ubp5DEu9VJASep9WJ','2016-06-08 04:53:52','2016-06-08 04:57:58',NULL),(30,'zaaa122','a@b.com','$2y$10$B79OMqg89BsKzPr1aO.mjuZgfvjfxXycsOYpnR.DK1w/tzCKUIL3u','1990-06-13','male',0,'default.jpg','','BmDgHOy2LOtRJZlBpHXP1LIGnqpuqeIEpQuqf1w0sIriP7trrVEXmaBsJXKz','2016-06-10 07:10:34','2016-06-10 07:11:17',NULL),(31,'dasa','d@c.com','$2y$10$WcCqkqmxwEkMm6OOLWu7lOgkfYT94xmC1xh3yM4W5jWg6qO5bHp/q','1990-06-13','male',8762834995,'default.jpg','Virgosys','zlxmavikOA200N4EO3Ay0lYmU4iRLlp5SeuMmDP75GkkxElGuLavrZL3mWor','2016-06-10 07:10:45','2016-06-10 07:13:51',NULL),(32,'ganesh','gani@gmail.com','$2y$10$hHCZUU18maWUfI6MoMebI.rO21bhJoB3yOq3Ir/ZeWOxKOish13.y','1990-06-14','male',8762344567,'default.jpg','','ULqki2eMN1RPuHPyvT3kX2TYEA0nbGUp3akog9BvMnPq2BatYsjTgn1BI7oH','2016-06-10 07:18:32','2016-06-10 07:28:47',NULL),(33,'1111','a@n.cc1','$2y$10$x6jPN6LGTUZuFfH4xCvlHeYeW7X0JjpYUYHwGe5OZvX6MYoBE6WM.','2000-06-06','female',0,'default.jpg','Virgosys',NULL,'2016-06-10 09:08:13','2016-06-10 09:08:13',NULL),(34,'abc','a@b.c','e80b5017098950fc58aad83c8c14978e','2000-06-02','male',8050777742,'default.jpg','','9EF34OAHYeYQH8ZSF32joqbaWcY6ZX9rDniMrZAeFazlJEykjtQFbg7jGCl8','2016-06-20 07:23:38','2016-06-20 07:23:45',NULL),(35,'hhhhhh','h@h.h','e10adc3949ba59abbe56e057f20f883e','2000-06-08','female',1231243234,'images/h@h.h.png','','iKPTvHxuJRXoSkbnpoeOQth4ToY5rAE3CDJlcMDtXz7j8qp1YfRJdVUUTQM3','2016-06-20 23:45:59','2016-06-20 23:52:06',NULL),(36,'lokesh','lokeshkr@gmail.com','e10adc3949ba59abbe56e057f20f883e','1990-01-11','male',8970603047,'default.jpg','','aFUVHO6JFKFs2i4rlgrqpIy4GDKid4rSTptNVgxCH1Yar6HrR3vHKF8hezR7','2016-07-02 04:21:09','2016-07-02 04:21:14',NULL),(37,'hhhhhhasd','hasd@dgfs.dcv','226280c5dd9b1bd4e67c72ff2c94bf1b','2000-07-03','male',8050777719,'default.jpg','Virgosys',NULL,'2016-07-06 08:13:28','2016-07-06 08:13:28',NULL),(38,'guruprasad','guru@gmail.com','b98641552407cf5ecd851bf44a367e9c','2000-07-13','male',9738786594,'default.jpg','','zlqJUh8CdmArzD8j9LuLiMpVKq4tUc55YbntEY2AUr2dj4lylNAZtj9KowAR','2016-07-13 00:01:47','2016-07-13 04:17:16',15007452);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `zone_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `range` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zones`
--

LOCK TABLES `zones` WRITE;
/*!40000 ALTER TABLE `zones` DISABLE KEYS */;
INSERT INTO `zones` VALUES (3,'Virgosys',12.993772,77.59443599999997,4,'2016-06-04 05:34:12','2016-07-14 01:47:41'),(8,'Charlotte',35.252882322211,-80.855507366882,2,'2016-06-16 08:04:24','2016-07-14 03:18:16'),(9,'United States',39.740986545715,-101.86523475000001,4,'2016-07-14 01:56:19','2016-07-14 03:15:03'),(10,'new zo',37.12528648180362,-94.52636756250001,7,'2016-07-16 04:24:46','2016-07-16 04:24:46');
/*!40000 ALTER TABLE `zones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-19 11:40:11
