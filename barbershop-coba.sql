/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.1.38-MariaDB : Database - barbershop-coba
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`barbershop-coba` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `barbershop-coba`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id_admin` varchar(30) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `nama_admin` varchar(50) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `admin` */

insert  into `admin`(`id_admin`,`username`,`nama_admin`,`password`) values 
('123','admin','alfhi lukman hakim','admin');

/*Table structure for table `bayar` */

DROP TABLE IF EXISTS `bayar`;

CREATE TABLE `bayar` (
  `id_bayar` varchar(30) NOT NULL,
  `id_booking` varchar(30) DEFAULT NULL,
  `jenis_bayar` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `bukti` longblob,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_bayar`),
  KEY `id_booking` (`id_booking`),
  CONSTRAINT `bayar_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id_booking`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bayar` */

insert  into `bayar`(`id_bayar`,`id_booking`,`jenis_bayar`,`jumlah`,`bukti`,`keterangan`) values 
('c0001','b0001','Ditempat',15,'fb.png','ayya'),
('c0002','b0002','dana',101,'uty.png','iya'),
('c0003','b0003','Ditempat',10100,'uty.png','asfag'),
('c0004','b0004','ditempat',10100,'uty.png','asfag'),
('c0005','b0005','gopay',10100,'uty.png','asfag'),
('c0006','b0006','bca',10100,'uty.png','asfag'),
('c0007','b0007','ovo',10100,'bukti.png','asfag'),
('c0008','b0008','bca',10100,'uty.png','asfag'),
('c0009','b0009','ovo',10100,'uty.png','asfag');

/*Table structure for table `booking` */

DROP TABLE IF EXISTS `booking`;

CREATE TABLE `booking` (
  `id_booking` varchar(30) NOT NULL,
  `id_layanan` varchar(30) DEFAULT NULL,
  `id_pelanggan` varchar(30) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id_booking`),
  KEY `id_layanan` (`id_layanan`),
  KEY `id_pelanggan` (`id_pelanggan`),
  CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`),
  CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `booking` */

insert  into `booking`(`id_booking`,`id_layanan`,`id_pelanggan`,`start_time`,`end_time`) values 
('b0001','s0001','p0001','2022-05-22 10:00:00','2022-05-22 11:00:00'),
('b0002','s0001','p0002','2022-05-22 17:00:00','2022-05-22 18:00:00'),
('b0003','s0006','p0007','2022-07-28 09:00:00','2022-07-28 10:00:00'),
('b0004','s0004','p0008','2022-07-29 10:00:00','2022-07-29 11:00:00'),
('b0005','s0004','p0003','2022-07-30 10:00:00','2022-07-30 11:00:00'),
('b0006','s0005','p0004','2022-08-01 10:00:00','2022-08-01 11:00:00'),
('b0007','s0007','p0005','2022-08-02 10:00:00','2022-08-02 11:00:00'),
('b0008','s0008','p0006','2022-08-03 10:00:00','2022-08-03 11:00:00'),
('b0009','s0009','p0009','2022-08-04 10:00:00','2022-08-04 11:00:00');

/*Table structure for table `layanan` */

DROP TABLE IF EXISTS `layanan`;

CREATE TABLE `layanan` (
  `id_layanan` varchar(30) NOT NULL,
  `id_admin` varchar(30) DEFAULT NULL,
  `nama_layanan` varchar(50) DEFAULT NULL,
  `harga_layanan` int(50) DEFAULT NULL,
  `durasi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_layanan`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `layanan_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `layanan` */

insert  into `layanan`(`id_layanan`,`id_admin`,`nama_layanan`,`harga_layanan`,`durasi`) values 
('s0001','123','cutting',20000,60),
('s0002','123','creambath',40000,60),
('s0003','123','coloring',75000,60),
('s0004','123','shaving',15000,60),
('s0005','123','highlight',50000,60),
('s0006','123','smoothing',50000,60),
('s0007','123','vitamin',10000,60),
('s0008','123','hair skin',20000,60),
('s0009','123','toning',15000,60),
('s0010','123','botak licin',50000,60);

/*Table structure for table `pelanggan` */

DROP TABLE IF EXISTS `pelanggan`;

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(16) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `nomor_hp` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pelanggan` */

insert  into `pelanggan`(`id_pelanggan`,`nama`,`email`,`password`,`alamat`,`tanggal_lahir`,`nomor_hp`) values 
('p0001','alfhi','alfhi@gmail.com','alfhi','tararahu','2000-01-10','86262626'),
('p0002','lukman','lukman@gmail.com','lukman','jalan kenangan 71','2001-08-10','8255412'),
('p0003','hakim','hakim@gmail.com','hakim','jonggol','2000-05-21','902121'),
('p0004','jajaja h','jajaja123@gmail.com','jajaja123','jalan mana','2000-01-01','087521375'),
('p0005','saya','saya@gmail.com','saya','mana saya tau','2000-11-21','91238'),
('p0006','coba','cobaja@gmail.com','coba','ntah','2000-06-05','8192892'),
('p0007','apakah','apakah@gmail.com','apakah','surakarta','2009-06-10','2928282'),
('p0008','kuncoro','kuncoro@gmail.com','kuncoro','kulon progo','2008-02-28','2147483647'),
('p0009','defa','defa@gmail.com','defa','jakarta','2002-05-21','9009082121');

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(30) NOT NULL,
  `id_bayar` varchar(30) DEFAULT NULL,
  `id_admin` varchar(30) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `id_bayar` (`id_bayar`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_bayar`) REFERENCES `bayar` (`id_bayar`),
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `transaksi` */

insert  into `transaksi`(`id_transaksi`,`id_bayar`,`id_admin`,`status`) values 
('t0001','c0001','123','valid'),
('t0002','c0002','123','valid'),
('t0003','c0003','123','valid'),
('t0004','c0004','123','valid'),
('t0005','c0005','123','valid'),
('t0006','c0006','123','valid'),
('t0007','c0007','123','valid'),
('t0008','c0008','123','valid'),
('t0009','c0009','123','valid');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
