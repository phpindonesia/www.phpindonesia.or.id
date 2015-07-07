-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2015 at 07:30 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phpindonesia`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id_album` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `seotitle` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `active` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_album`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id_album`, `title`, `seotitle`, `active`) VALUES
(1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm', 'Y'),
(2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `seotitle` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `active` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id_comment` int(10) NOT NULL AUTO_INCREMENT,
  `id_post` int(10) NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `url` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `comment` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date` date NOT NULL,
  `time` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `active` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `status` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_comment`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `component`
--

CREATE TABLE IF NOT EXISTS `component` (
  `id_component` int(10) NOT NULL AUTO_INCREMENT,
  `component` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date` date NOT NULL,
  `table_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_component`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `component`
--

INSERT INTO `component` (`id_component`, `component`, `date`, `table_name`) VALUES
(1, 'po-contact', '2014-08-11', 'contact'),
(2, 'po-gallery', '2014-08-11', 'gallery'),
(3, 'po-comment', '2014-08-11', 'comment'),
(4, 'po-video', '2015-07-05', 'video'),
(5, 'po-event', '2015-07-05', 'event');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id_contact` int(10) NOT NULL AUTO_INCREMENT,
  `name_contact` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email_contact` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `subjek_contact` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `message_contact` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `status` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_contact`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id_event` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `allday` enum('true','false') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'true',
  `content` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `seotitle` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `color` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `active` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id_event`, `title`, `start`, `end`, `allday`, `content`, `seotitle`, `color`, `active`) VALUES
(1, 'Hands-On YII Framework', '2012-04-14 08:00:00', '2012-04-14 12:00:00', 'false', '&lt;p&gt;Hands-On YII Framework&lt;br /&gt;Saturday, April 14, 2012 at 8:00am&lt;br /&gt;D&#039;Best Fatmawati&lt;br /&gt;Jl. RS. Fatmawati 15, Jakarta, Indonesia 12420&lt;br /&gt;&lt;br /&gt;Melanjutkan PHP Gathering Maret 2012 lalu, PHP Indonesia Group Bekerjasama dengan Yii PHP Framework Pada tanggal 14 April 2012 akan mengadakan Workshop Yii Framework untuk 10 orang peserta, video streaming untuk 25 saluran dan video record untuk di jadikan video tutorial, Pemateri om @Peter Jack Kambey. Bagi Yang berminat silahkan melakukan Pendaftaran di sini :&lt;br /&gt;&lt;br /&gt;http://www.enterprisephpcenter.com/jobs/webinars-schedule/?ee=15&lt;br /&gt;&lt;br /&gt;Bagi pendaftar yang ingin datang langsung wajib membayar Rp.35.000. Biaya ini semata-mata hanya untuk konsumsi peserta dan pemateri. Cara pembayaran bisa dibayar langsung atau transfer ke rekening BCA saya sehari sebelum Acara Workshop.&lt;br /&gt;Bagi yang ingin transfer pembayaran untuk konsumsi di workshop bisa transfer langsung ke rekening BCA saya&lt;br /&gt;Norek : 2181617120&lt;br /&gt;a/n : AWALUDIN RAHMADI&lt;br /&gt;&lt;br /&gt;Adapun fasilitas yang disediakan hanya tempat dan dan koneksi internet. Sedangkan laptop bawa masing-masing.&lt;/p&gt;', 'handson-yii-framework', '1BBAE1', 'Y'),
(2, 'Hands-On Code Igniter PHP Framework', '2012-04-21 09:00:00', '2012-04-21 16:00:00', 'false', '&lt;p&gt;Hands-On Code Igniter PHP Framework&lt;br /&gt;Saturday, April 21, 2012 at 9:00am - 4:00pm&lt;br /&gt;D&#039;Best Fatmawati&lt;br /&gt;Jl. RS. Fatmawati 15, Jakarta, Indonesia 12420&lt;br /&gt;&lt;br /&gt;PHP Indonesia Group Bekerjasama dengan Group Code Igniter Framework Indonesia akan mengadakan Workshop Code Igniter PHP Framework.&lt;br /&gt;&lt;br /&gt;Tanggal : 21 April 2012&lt;br /&gt;Jam : 09.00-16.00&lt;br /&gt;Tempat : Basecamp PHP Indonesia, Kompleks Ruko Dbest Fatmawati Blok D18&lt;br /&gt;Pemateri : Gunawan Wibisono&lt;br /&gt;&lt;br /&gt;Peserta onsite hanya untuk 10 orang peserta, untuk yang online bisa via video streaming untuk 25 saluran dan video record untuk di jadikan video tutorial.&lt;br /&gt;&lt;br /&gt;Bagi Yang berminat silahkan melakukan Pendaftaran di sini :&lt;br /&gt;&lt;br /&gt;http://www.enterprisephpcenter.com/jobs/webinars-schedule/?ee=16&lt;br /&gt;&lt;br /&gt;Bagi pendaftar yang ingin datang langsung wajib membayar Rp.35.000. Biaya ini semata-mata hanya untuk konsumsi peserta dan pemateri. Cara pembayaran bisa dibayar langsung atau transfer ke rekening BCA saya sehari sebelum Acara Workshop.&lt;br /&gt;Bagi yang ingin transfer pembayaran untuk konsumsi di workshop bisa transfer langsung ke rekening BCA.&lt;br /&gt;Norek : 2181617120&lt;br /&gt;a/n : AWALUDIN RAHMADI&lt;br /&gt;&lt;br /&gt;Adapun fasilitas yang disediakan hanya tempat dan dan koneksi internet. Sedangkan laptop bawa masing2..&lt;br /&gt;&lt;br /&gt;NB : bagi yang sudah melakukan pembayaran via Transfer, harap mengrimkan konfirmasi via email ke alamat ini : awal@rynet.com.sg&lt;/p&gt;', 'handson-code-igniter-php-framework', '888', 'Y'),
(3, 'BaseCamp PHP Indonesia Open House', '2012-04-21 00:00:00', '2012-04-22 00:00:00', 'true', '&lt;p&gt;BaseCamp PHP Indonesia Open House&lt;br /&gt;April 21, 2012 - April 22, 2012&lt;br /&gt;Jl. RS Fatmawati No.15 Jakarta Selatan, Kompleks Ruko Golden Plaza(D&#039;Best) Blok D-18, LOTTE Mart Fatmawati&lt;br /&gt;&lt;br /&gt;Untuk menjalin keakraban sesama coder PHP Setiap hari sabtu dan minggu PHP Indonesia Group melaksanakan kegiatan Open House PHP Indonesia di basecamp Fatmawati mulai Pukul 10 Pagi hingga pukul 4 sore.&lt;br /&gt;&lt;br /&gt;Lokasi&lt;br /&gt;&lt;br /&gt;Kompleks Ruko Golden Plaza(D&#039;Best) Blok D-18&lt;br /&gt;Jl. RS Fatmawati No.15&lt;br /&gt;LOTTE Mart Fatmawati&lt;br /&gt;Jakarta 12420, INDONESIA&lt;br /&gt;Phone : +62-21-7506846 (Hanya Sabtu dan Minggu Pukul 10 Pagi hingga Pukul 4 Sore)&lt;br /&gt;&lt;br /&gt;&quot;ACARA INI TERRBUKA BAGI SEMUA ANGGOTA PHP INDONESIA GROUP&quot;&lt;/p&gt;', 'basecamp-php-indonesia-open-house', 'AF64CC', 'Y'),
(4, 'PHP How To Program', '2012-04-22 10:00:00', '2012-04-22 16:00:00', 'false', '&lt;p&gt;PHP How To Program&lt;br /&gt;Sunday, April 22, 2012 at 10:00am - 4:00pm&lt;br /&gt;D&#039;Best Fatmawati&lt;br /&gt;Jl. RS. Fatmawati 15, Jakarta, Indonesia 12420&lt;br /&gt;&lt;br /&gt;PHP Indonesia Group akan mengadakan Workshop PHP Basic. Workshop PHP Basic ini ditujukan bagi yang baru belajar tentang PHP.&lt;br /&gt;&lt;br /&gt;Tanggal : 22 April 2012&lt;br /&gt;Jam : 10.00-16.00&lt;br /&gt;Tempat : Basecamp PHP Indonesia, Kompleks Ruko Dbest Fatmawati Blok D18&lt;br /&gt;Pemateri : La Jayuhni Yarsyah&lt;br /&gt;&lt;br /&gt;Peserta onsite hanya untuk 10 orang peserta, untuk yang online bisa via video streaming untuk 25 saluran dan video record untuk di jadikan video tutorial.&lt;br /&gt;&lt;br /&gt;Bagi Yang berminat silahkan melakukan Pendaftaran di sini :&lt;br /&gt;&lt;br /&gt;http://www.enterprisephpcenter.com/jobs/webinars-schedule/?ee=17&lt;br /&gt;&lt;br /&gt;Bagi pendaftar yang ingin datang langsung wajib membayar Rp.35.000. Biaya ini semata-mata hanya untuk konsumsi peserta dan pemateri. Cara pembayaran bisa dibayar langsung atau transfer ke rekening BCA saya sehari sebelum Acara Workshop.&lt;br /&gt;Bagi yang ingin transfer pembayaran untuk konsumsi di workshop bisa transfer langsung ke rekening BCA.&lt;br /&gt;Norek : 2181617120&lt;br /&gt;a/n : AWALUDIN RAHMADI&lt;br /&gt;&lt;br /&gt;Adapun fasilitas yang disediakan hanya tempat dan dan koneksi internet. Sedangkan laptop bawa masing2..&lt;br /&gt;&lt;br /&gt;NB : bagi yang sudah melakukan pembayaran via Transfer, harap mengrimkan konfirmasi via email ke alamat ini : awal@rynet.com.sg&lt;/p&gt;', 'php-how-to-program', '46B7BF', 'Y'),
(5, 'PHP Indonesia Gathering Pacitan Jawa Timur', '2012-04-29 09:00:00', '2012-04-29 17:00:00', 'false', '&lt;p&gt;PHP Indonesia Gathering Pacitan Jawa Timur - April 2012&lt;br /&gt;Sunday, April 29, 2012 at 9:00am - 5:00pm&lt;br /&gt;JL. WALANDA MARAMIS NO.2 PACITAN, JAWA TIMUR&lt;br /&gt;&lt;br /&gt;PHP Indonesia Facebook Group Wilayah Pacitan Jawa Timur, akan mengadakan event Gathering / Kopi darat di untuk mempererat keakraban antara sesama member PHP Indonesia, mempertajam skill dan pengetahuan PHP, serta semakin mempopulerkan penggunaan PHP di Indonesia.&lt;br /&gt;&lt;br /&gt;Lokasi Acara di&lt;br /&gt;&lt;br /&gt;SMKN 2 PACITAN JL. WALANDA MARAMIS NO.2 PACITAN, JAWA TIMUR&lt;br /&gt;&lt;br /&gt;Event ini terselenggara atas kerja sama yang erat antara sesama member PHP Indonesia serta kolaborasi dengan corporate sponsors.&lt;br /&gt;&lt;br /&gt;Special Thanks to PT Microsoft Indonesia, Rhynet, Telkom Divre V Jawa Timur.&lt;br /&gt;&lt;br /&gt;Organizing Committee (more volunteers are welcome):&lt;br /&gt;- Eksa Aja&lt;br /&gt;- Krisno W Utomo&lt;br /&gt;- Sony A.K&lt;br /&gt;- Rama Yurindra&lt;br /&gt;- Luri Darmawan&lt;br /&gt;- Ridho Prasetya&lt;/p&gt;', 'php-indonesia-gathering-pacitan-jawa-timur', 'E67E22', 'Y'),
(6, 'PHP Webservices', '2012-04-29 10:00:00', '2012-04-29 17:00:00', 'false', '&lt;p&gt;PHP Webservices&lt;br /&gt;Sunday, April 29, 2012 at 10:00am - 4:00pm&lt;br /&gt;D&#039;Best Fatmawati&lt;br /&gt;Jl. RS. Fatmawati 15, Jakarta, Indonesia 12420&lt;br /&gt;&lt;br /&gt;PHP Indonesia Group akan mengadakan Workshop PHP webservices. Workshop ini menerangkan tentang bagaimana membuat Aplikasi berbasis Webservices dengan bahasa pemrograman PHP.&lt;br /&gt;&lt;br /&gt;Tanggal : 29 April 2012&lt;br /&gt;Jam : 10.00-16.00&lt;br /&gt;Tempat : Basecamp PHP Indonesia, Kompleks Ruko Dbest Fatmawati Blok D18&lt;br /&gt;Pemateri : Muchamad Rochim&lt;br /&gt;&lt;br /&gt;Peserta onsite hanya untuk 10 orang peserta, untuk yang online bisa via video streaming untuk 25 saluran dan video record untuk di jadikan video tutorial.&lt;br /&gt;&lt;br /&gt;Bagi Yang berminat silahkan melakukan Pendaftaran di sini :&lt;br /&gt;&lt;br /&gt;http://www.enterprisephpcenter.com/jobs/webinars-schedule/?ee=18&lt;br /&gt;&lt;br /&gt;Bagi pendaftar yang onsite wajib membayar Rp. 100.000, sedangkan yang ingin mengikutu online via webex tidak dipungut biaya. Peserta yang onsite akan mendapatkan Cemilan Coffe Break, Makan siang, Sertifikat Training, dan DVD Rekaman training.&lt;br /&gt;&lt;br /&gt;Cara pembayaran bisa dibayar langsung atau transfer ke rekening BCA saya sehari sebelum Acara Workshop. Bagi yang ingin transfer pembayaran untuk konsumsi di workshop bisa transfer langsung ke rekening BCA.&lt;br /&gt;Norek : 2181617120&lt;br /&gt;a/n : AWALUDIN RAHMADI&lt;br /&gt;&lt;br /&gt;Bagi pendaftar yang sudah bayar harap segera mengkonfirmasi pembayarannya dengan mengirimkan konfimasi pembayaran ke, awal@rynet.com.sg.&lt;br /&gt;&lt;br /&gt;Adapun fasilitas yang disediakan hanya tempat dan dan koneksi internet. Sedangkan laptop bawa masing-masing.&lt;/p&gt;', 'php-webservices', '1EC1B8', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id_gallery` int(10) NOT NULL AUTO_INCREMENT,
  `id_album` int(10) NOT NULL,
  `title` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `picture` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_gallery`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id_gallery`, `id_album`, `title`, `picture`) VALUES
(1, 1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm-5.jpg'),
(2, 1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm-4.jpg'),
(3, 1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm-3.jpg'),
(4, 1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm-2.jpg'),
(5, 1, 'Membangun Aplikasi HRIS, IBM', 'membangun-aplikasi-hris-ibm-1.jpg'),
(6, 2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm-5.jpg'),
(7, 2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm-4.jpg'),
(8, 2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm-3.jpg'),
(9, 2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm-2.jpg'),
(10, 2, 'Pelatihan PHP on System-I IBM', 'pelatihan-php-on-systemi-ibm-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id_media` int(10) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `file_type` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `file_size` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id_media`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `class` varchar(255) NOT NULL DEFAULT '',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `title`, `url`, `class`, `position`, `group_id`) VALUES
(1, 0, 'Home', './', '', 1, 1),
(2, 0, 'Tentang Kami', 'pages/tentang-kami', 'menu-item-simple-parent', 2, 1),
(3, 2, 'Struktur Organisasi', 'pages/struktur-organisasi', '', 3, 1),
(4, 2, 'Sejarah', 'pages/sejarah', '', 2, 1),
(5, 2, 'Pengurus', 'pages/kepengurusan', '', 4, 1),
(6, 0, 'Program Kerja', 'pages/program-kerja', 'menu-item-simple-parent', 3, 1),
(7, 6, 'Nasional', 'pages/program-kerja-nasional', '', 1, 1),
(8, 6, 'Daerah', 'pages/program-kerja-daerah', '', 2, 1),
(9, 0, 'Dokumen', 'pages/ad-art', 'menu-item-simple-parent', 4, 1),
(19, 9, 'AD/ART', 'pages/ad-art', '', 1, 1),
(20, 9, 'Surat Keputusan', 'pages/surat-keputusan', '', 2, 1),
(21, 0, 'Galeri', 'album', 'menu-item-simple-parent', 5, 1),
(22, 21, 'Photo', 'album', '', 1, 1),
(23, 21, 'Video', 'valbum', '', 2, 1),
(24, 0, 'Kontak', 'contact', '', 6, 1),
(26, 9, 'Event', 'listevent', '', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_group`
--

CREATE TABLE IF NOT EXISTS `menu_group` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `menu_group`
--

INSERT INTO `menu_group` (`id`, `title`) VALUES
(1, 'Main Menu');

-- --------------------------------------------------------

--
-- Table structure for table `oauth`
--

CREATE TABLE IF NOT EXISTS `oauth` (
  `id_oauth` int(10) NOT NULL AUTO_INCREMENT,
  `oauth_type` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `oauth_key` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `oauth_secret` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `oauth_id` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `oauth_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `oauth_token1` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `oauth_token2` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `oauth_fbtype` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_oauth`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `oauth`
--

INSERT INTO `oauth` (`id_oauth`, `oauth_type`, `oauth_key`, `oauth_secret`, `oauth_id`, `oauth_user`, `oauth_token1`, `oauth_token2`, `oauth_fbtype`) VALUES
(1, 'facebook', '', '', '', '', '', '', ''),
(2, 'twitter', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id_pages` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `content` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `seotitle` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `picture` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `active` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_pages`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id_pages`, `title`, `content`, `seotitle`, `picture`, `active`) VALUES
(1, 'Tentang Kami', '&lt;p&gt;PHP Indonesia adalah komunitas pemrogram berbasis Bahasa Scripting PHP yang pertama kali disusun oleh Rasmus Lerdorf kemudian dikembangkan oleh Zeev Surasky dan Andy Gutzman dengan interpreteur Zend Engines, serta dikembangkan oleh anggota komunitas dari seluruh dunia. Untuk saat ini, bahasa scripting PHP merupakan salah satu bahasa pemrograman berbasis web yang sangat popular, sehubungan dengan trend bisnis saat ini yang cenderung menggunakan aplikasi berbasis web.&lt;br /&gt;&lt;br /&gt;Pada awalnya PHP Indonesia merupakan sebuah Group diskusi online di facebook yang dibuat pada tanggal 8 Februari 2008 oleh Sonny Arlianto Kurniawan, atas usulan Rama Yurindra pada tanggal 6 Februari 2008 disebuah Caf&amp;eacute; di kemang.&lt;br /&gt;&lt;br /&gt;Pada tanggal 31 Maret 2012 bertempat di Auditorium PT Microsoft Gedung BEJ II lt 19, Jakarta, diadakan Gathering anggota yang menjadi salah satu tonggak sejarah penting komunitas PHP Indonesia. Pada pertemuan ini, bertemu para anggota yang memiliki passion untuk lebih mengembangkan komunitas PHP Indonesia tidak hanya sebatas group diskusi online, akan tetapi menyusun struktur organisasi dengan membentuk perwakilan PHP Indonesia diseluruh kota Indonesia yang semuanya dilaksanakan oleh anggota komunitas ini yang memiliki spirit dan passion yang sama. Sejak tahun 2012 hingga tahun 2015 telah terbentuk perwakilan komunitas PHP Indonesia hingga di 14 Provinsi.&lt;br /&gt;&lt;br /&gt;Dalam aktivitasnya, perwakilan PHP Indonesia, secara periodik melakukan Meet Up, Gathering, Workshop, atau seminar, baik bekerja sama dengan Institusi kampus pendidikan tinggi, bekerja sama dengan komunitas IT lainnya, dan bantuan dari perusahaan-perusahaan berbasis telekomunikasi. Sedang di Jakarta, aktivitas komunitas PHP Indonesia cukup banyak mendapat dukungan dari perusahaan IT Multi Nasional seperti PT Microsoft Indonesia, PT IBM Indonesia, Detik.com, perusahaan e-commerce seperti Ezytravel.co,id serta lembaga nirlaba lainnya seperti GEPI (Global Entrepreneur Program Incubator), dan lain-lain.&lt;br /&gt;&lt;br /&gt;Perkembangan anggota diskusi online berkembang sangat pesat, pada awal Juni 2015 telah bergabung lebih dari 81.000 anggota.&amp;nbsp; Banyak anggota serta kenyataan begitu banyak anggota yang memiliki latar belakang keahlian pemrograman dari berbagai bahasa pemrograman serta keahlian tekhnologi informasi lainnya, seperti teknologi jaringan dan multimedia, pada akhirnya komunitas PHP Indonesia tidak lagi khusus bagi pemrogram PHP, akan tetapi sudah menjadi rumah besar bagi komunitas IT nasional. Sehingga group PHP Indonesia di Facebook merupakan group IT di Indonesia yang terbesar dan teraktif di media social Facebook.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p style=&quot;text-align: center; font-size: 18px;&quot;&gt;&lt;strong&gt;VISI :&lt;/strong&gt;&lt;br /&gt;PHP Indonesia bermaksud menghimpun, mendorong meningkatkan dan memanfaatkan potensi segenap pihak yang bergerak di bidang Pemrograman PHP dan Pemrograman lainnya yang mendukung, untuk mewujudkan suatu kondisi yang saling melengkapi dalam rangka pencapaian tujuan PHP Indonesia.&lt;br /&gt;&lt;br /&gt;&lt;strong&gt;MISI :&lt;/strong&gt;&lt;br /&gt;PHP Indonesia bertujuan menumbuhkan, mengembangkan dan meningkatkan keahlian, produktivitas, profesionalisme, peningkatan daya saing untuk pemenuhan pasar piranti lunak nasional dalam rangka pembangunan bangsa dan negara, melalui sumber daya pemrogram berbasis PHP dalam lingkup nasional, dan meningkatkan kesejahteraan anggota.&lt;/p&gt;', 'tentang-kami', '', 'Y'),
(2, 'Sejarah', '&lt;p&gt;Pada awalnya PHP Indonesia merupakan sebuah Group diskusi online di facebook yang dibuat pada tanggal 8 Februari 2008 oleh Sonny Arlianto Kurniawan, atas usulan Rama Yurindra pada tanggal 6 Februari 2008 disebuah Caf&amp;eacute; di kemang.&lt;br /&gt;&lt;br /&gt;Pada tanggal 31 Maret 2012 bertempat di Auditorium PT Microsoft Gedung BEJ II lt 19, Jakarta, diadakan Gathering anggota yang menjadi salah satu tonggak sejarah penting komunitas PHP Indonesia. Pada pertemuan ini, bertemu para anggota yang memiliki passion untuk lebih mengembangkan komunitas PHP Indonesia tidak hanya sebatas group diskusi online, akan tetapi menyusun struktur organisasi dengan membentuk perwakilan PHP Indonesia diseluruh kota Indonesia yang semuanya dilaksanakan oleh anggota komunitas ini yang memiliki spirit dan passion yang sama. Sejak tahun 2012 hingga tahun 2015 telah terbentuk perwakilan komunitas PHP Indonesia hingga di 14 Provinsi.&lt;/p&gt;', 'sejarah', '', 'Y'),
(3, 'Struktur Organisasi', '&lt;div class=&quot;banner&quot;&gt;&lt;img class=&quot;struktur-org&quot; src=&quot;http://localhost/phpindonesia/po-content/po-upload/struktur-organisasi.jpg&quot; alt=&quot;Struktur Organisasi&quot; /&gt;&lt;/div&gt;', 'struktur-organisasi', '', 'Y'),
(4, 'Kepengurusan', '', 'kepengurusan', '', 'Y'),
(5, 'Program Kerja', '&lt;p&gt;Program Kerja PHP Indonesia mencakup namun tidak terbatas pada :&lt;/p&gt;\r\n&lt;ol&gt;\r\n&lt;li&gt;Mengupayakan peningkatan kemampuan dan profesionalisme para anggota dalam menghadapi kemajuan ilmu pengetahuan, teknologi dan perdagangan di bidang telematika khususnya dibidang yang berkaitan dengan pemrograman PHP dalam bentuk pelaksaan seminar, gathering, meetup, workshop dan bentuk edukasi lainnya.&lt;/li&gt;\r\n&lt;li&gt;Membina dan mempererat hubungan kerjasama dengan organisasi, lembaga-lembaga profesional dan perorangan di bidang telematika, baik di dalam maupun di luar negeri, dengan tujuan pengakuan profesi di pasar lokal ataupun internasional yang pada akhirnya akan berimbas pada peningkatan posisi tawar dalam pasar software nasional baik berbasis web ataupun tidak berbasis web.&lt;/li&gt;\r\n&lt;li&gt;PHP Indonesia akan menginisiasi segala aktivitas yang akan meningkatkan posisi tawar pemrogram yang berprofesi sebagai pengembang aplikasi berbasis PHP, untuk tujuan peningkatan kesejahteraan anggota dalam bentuk mengupayakan NOTA KESEPAHAMAN dengan Vendor yang menerbitkan sertfikasi profesi, ataupun harga khusus untuk produk-produk software pendukung kinerja pemrograman dan bentuk-bentuk NOTA KESEPAHAMAN lainnya yang dapat meningkatkan posisi tawar dan taraf kesejahteraan anggota.&lt;/li&gt;\r\n&lt;li&gt;PHP Indonesia akan menginisiasi segala aktivitas yang berkaitan dengan pembentukan kelompok kerja yang akan mengarah pada usaha bersama (mutual corporate) dari para anggota yang berprofesi sebagai free lancer, pembinaan dan pendampingan dari sisi manajemen, bantuan pemasaran dan bantuan hukum bagi anggotanya sehingga di harapkan tumbuh usaha-usaha piranti lunak profesional dan kolegatif.&lt;/li&gt;\r\n&lt;li&gt;Menghindari konflik antar anggota yang berkaitan dengan perebutan pasar PHP Develeper dengan jalan menumbuhkan semangat kolegatif dan pemetaan pasar.&lt;/li&gt;\r\n&lt;/ol&gt;', 'program-kerja', '', 'Y'),
(6, 'Program Kerja Nasional', '&lt;div class=&quot;error-info&quot;&gt;\r\n&lt;h2&gt;Content Under Construction&lt;/h2&gt;\r\n&lt;h3&gt;Untuk sementara konten di halaman ini masih dalam tahap perbaikan.&lt;/h3&gt;\r\n&lt;/div&gt;', 'program-kerja-nasional', '', 'Y'),
(7, 'Program Kerja Daerah', '&lt;div class=&quot;error-info&quot;&gt;\r\n&lt;h2&gt;Content Under Construction&lt;/h2&gt;\r\n&lt;h3&gt;Untuk sementara konten di halaman ini masih dalam tahap perbaikan.&lt;/h3&gt;\r\n&lt;/div&gt;', 'program-kerja-daerah', '', 'Y'),
(8, 'AD/ART', '&lt;div class=&quot;error-info&quot;&gt;\r\n&lt;h2&gt;Content Under Construction&lt;/h2&gt;\r\n&lt;h3&gt;Untuk sementara konten di halaman ini masih dalam tahap perbaikan.&lt;/h3&gt;\r\n&lt;/div&gt;', 'ad-art', '', 'Y'),
(9, 'Surat Keputusan', '&lt;div class=&quot;error-info&quot;&gt;\r\n&lt;h2&gt;Content Under Construction&lt;/h2&gt;\r\n&lt;h3&gt;Untuk sementara konten di halaman ini masih dalam tahap perbaikan.&lt;/h3&gt;\r\n&lt;/div&gt;', 'surat-keputusan', '', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int(10) NOT NULL AUTO_INCREMENT,
  `id_category` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `title` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `content` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `seotitle` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tag` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `editor` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `active` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `headline` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `picture` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `hits` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id_setting` int(5) NOT NULL AUTO_INCREMENT,
  `website_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `website_url` varchar(100) CHARACTER SET latin1 NOT NULL,
  `website_email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `meta_description` varchar(250) CHARACTER SET latin1 NOT NULL,
  `meta_keyword` varchar(250) CHARACTER SET latin1 NOT NULL,
  `favicon` varchar(50) CHARACTER SET latin1 NOT NULL,
  `timezone` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `website_maintenance` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `website_maintenance_tgl` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `website_cache` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `website_cache_time` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `member_register` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_setting`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id_setting`, `website_name`, `website_url`, `website_email`, `meta_description`, `meta_keyword`, `favicon`, `timezone`, `website_maintenance`, `website_maintenance_tgl`, `website_cache`, `website_cache_time`, `member_register`) VALUES
(1, 'PHP Indonesia | Bersama Berkaya Berjaya', 'http://localhost/phpindonesia', 'info@phpindonesia.or.id', 'PHP Indonesia is a community for everyone that loves PHP. Our focus is in the PHP world but our topics encompass the entire LAMP stack. Topics include PHP coding, to memcached handling, db optimizations, server stack, web server tuning, code deployin', 'popojicms, website popojicms, cms indonesia, cms terbaik indonesia, cms gratis, cms gratis indonesia, alternatif cms', 'favicon.png', 'Asia/Jakarta', 'N', '', 'N', '', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `subscribe`
--

CREATE TABLE IF NOT EXISTS `subscribe` (
  `id_subscribe` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_subscribe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id_tag` int(5) NOT NULL AUTO_INCREMENT,
  `tag_title` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `tag_seo` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `count` int(5) NOT NULL,
  PRIMARY KEY (`id_tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id_theme` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `author` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `folder` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `active` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_theme`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`id_theme`, `title`, `author`, `folder`, `active`) VALUES
(1, 'PHP Indonesia', 'Dwira Survivor', 'phpindo', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `traffic`
--

CREATE TABLE IF NOT EXISTS `traffic` (
  `ip` varchar(20) NOT NULL DEFAULT '',
  `tanggal` date NOT NULL,
  `hits` int(10) NOT NULL DEFAULT '1',
  `online` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `traffic`
--

INSERT INTO `traffic` (`ip`, `tanggal`, `hits`, `online`) VALUES
('::1', '2015-07-07', 21, '1436286905'),
('::1', '2015-07-08', 37, '1436290073');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(10) NOT NULL,
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `no_telp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `bio` text COLLATE latin1_general_ci NOT NULL,
  `userpicture` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `level` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '2',
  `blokir` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `id_session` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `tgl_daftar` date NOT NULL,
  `forget_key` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `locktype` varchar(1) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `email`, `no_telp`, `bio`, `userpicture`, `level`, `blokir`, `id_session`, `tgl_daftar`, `forget_key`, `locktype`) VALUES
(1, 'admweb', 'dfb607a9ad39b8b9af500ae128d18f42', 'Administrator', 'info@phpindonesia.or.id', '08xxxxxxxxxx', 'No matter how exciting or significant a person''s life is, a poorly written biography will make it seem like a snore. On the other hand, a good biographer can draw insight from an ordinary life-because they recognize that even the most exciting life is an ordinary life! After all, a biography isn''t supposed to be a collection of facts assembled in chronological order; it''s the biographer''s interpretation of how that life was different and important.', '', '1', 'N', 'va9u756342gor8qnkc0clpimb4', '2015-07-04', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE IF NOT EXISTS `user_level` (
  `id_level` int(10) NOT NULL AUTO_INCREMENT,
  `level` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_level`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`id_level`, `level`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id_role` int(10) NOT NULL AUTO_INCREMENT,
  `id_level` int(10) NOT NULL,
  `module` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `read_access` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `write_access` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `modify_access` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `delete_access` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_role`, `id_level`, `module`, `read_access`, `write_access`, `modify_access`, `delete_access`) VALUES
(1, 1, 'post', 'Y', 'Y', 'Y', 'Y'),
(2, 1, 'category', 'Y', 'Y', 'Y', 'Y'),
(3, 1, 'tag', 'Y', 'Y', 'Y', 'Y'),
(4, 1, 'pages', 'Y', 'Y', 'Y', 'Y'),
(5, 1, 'library', 'Y', 'Y', 'Y', 'Y'),
(6, 1, 'setting', 'Y', 'Y', 'Y', 'Y'),
(7, 1, 'theme', 'Y', 'Y', 'Y', 'Y'),
(8, 1, 'menumanager', 'Y', 'Y', 'Y', 'Y'),
(9, 1, 'component', 'Y', 'Y', 'Y', 'Y'),
(10, 1, 'user', 'Y', 'Y', 'Y', 'Y'),
(11, 1, 'comment', 'Y', 'Y', 'Y', 'Y'),
(12, 1, 'gallery', 'Y', 'Y', 'Y', 'Y'),
(13, 1, 'contact', 'Y', 'Y', 'Y', 'Y'),
(14, 1, 'cogen', 'Y', 'Y', 'Y', 'Y'),
(15, 2, 'post', 'Y', 'Y', 'Y', 'Y'),
(16, 2, 'category', 'Y', 'Y', 'Y', 'Y'),
(17, 2, 'tag', 'Y', 'Y', 'Y', 'Y'),
(18, 2, 'pages', 'Y', 'Y', 'Y', 'Y'),
(19, 2, 'library', 'Y', 'Y', 'Y', 'Y'),
(20, 2, 'setting', 'N', 'N', 'N', 'N'),
(21, 2, 'theme', 'N', 'N', 'N', 'N'),
(22, 2, 'menumanager', 'N', 'N', 'N', 'N'),
(23, 2, 'component', 'Y', 'N', 'N', 'N'),
(24, 2, 'user', 'Y', 'N', 'Y', 'N'),
(25, 2, 'comment', 'Y', 'Y', 'Y', 'Y'),
(26, 2, 'gallery', 'Y', 'Y', 'Y', 'Y'),
(27, 2, 'contact', 'Y', 'Y', 'Y', 'Y'),
(28, 2, 'cogen', 'Y', 'Y', 'Y', 'Y'),
(29, 3, 'post', 'Y', 'Y', 'Y', 'Y'),
(30, 3, 'category', 'Y', 'Y', 'Y', 'Y'),
(31, 3, 'tag', 'Y', 'Y', 'Y', 'Y'),
(32, 3, 'pages', 'N', 'N', 'N', 'N'),
(33, 3, 'library', 'N', 'N', 'N', 'N'),
(34, 3, 'setting', 'N', 'N', 'N', 'N'),
(35, 3, 'theme', 'N', 'N', 'N', 'N'),
(36, 3, 'menumanager', 'N', 'N', 'N', 'N'),
(37, 3, 'component', 'N', 'N', 'N', 'N'),
(38, 3, 'user', 'Y', 'N', 'Y', 'N'),
(39, 3, 'comment', 'N', 'N', 'N', 'N'),
(40, 3, 'gallery', 'N', 'N', 'N', 'N'),
(41, 3, 'contact', 'N', 'N', 'N', 'N'),
(42, 3, 'cogen', 'N', 'N', 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `valbum`
--

CREATE TABLE IF NOT EXISTS `valbum` (
  `id_album` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `seotitle` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `active` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_album`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `valbum`
--

INSERT INTO `valbum` (`id_album`, `title`, `seotitle`, `active`) VALUES
(1, 'PHP Webinar', 'php-webinar', 'Y'),
(2, 'PHP Indonesia Event Depok', 'php-indonesia-event-depok', 'Y'),
(3, 'PHP Indonesia Event Jakarta', 'php-indonesia-event-jakarta', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id_video` int(10) NOT NULL AUTO_INCREMENT,
  `id_album` int(10) NOT NULL,
  `title` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `url` varchar(300) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `picture` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_video`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id_video`, `id_album`, `title`, `url`, `picture`) VALUES
(1, 1, 'Pengenalan PHP di IBM i Bagian 2', 'https://www.youtube.com/embed/iZ0Aywi0rvg', 'php-webinar.jpg'),
(2, 1, 'Pengenalan PHP di IBM i Bagian 1', 'https://www.youtube.com/embed/mRsHfJX_IA0', 'php-webinar.jpg'),
(3, 1, 'PHP Indonesia With NoSQL Indonesia', 'https://www.youtube.com/embed/mI06K4e-X5c', 'php-webinar.jpg'),
(4, 1, 'EPHPC Webinar', 'https://www.youtube.com/embed/GyGyobbY3b8', 'php-webinar.jpg'),
(5, 2, 'Code Igniter Crash Course - Breaking The Frameworks', 'https://www.youtube.com/embed/D2sYZvmoDfc', 'php-indonesia-event-depok.jpg'),
(6, 3, 'Mengemas Website dengan Harga Layak', 'https://www.youtube.com/embed/GFXSdvqLyno', 'php-indonesia-event-jakarta.jpg'),
(7, 3, 'Women Technopreneurs', 'https://www.youtube.com/embed/gRORkht4QYs', 'php-indonesia-event-jakarta.jpg'),
(8, 3, 'Profesionalisme PHP Indonesia', 'https://www.youtube.com/embed/vE2YaIAZtL8', 'php-indonesia-event-jakarta.jpg'),
(9, 3, 'IBM i Power PHP Indonesia on IBM', 'https://www.youtube.com/embed/joZucxcwB1U', 'php-indonesia-event-jakarta.jpg'),
(10, 3, 'ERP Application PHP Indonesia on IBM', 'https://www.youtube.com/embed/XtVxMqv6p5M', 'php-indonesia-event-jakarta.jpg'),
(11, 3, 'Opening PHP Indonesia on IBM', 'https://www.youtube.com/embed/8XzbjLDXrPM', 'php-indonesia-event-jakarta.jpg'),
(12, 3, 'Optimize PHP Application in High Traffic Environment', 'https://www.youtube.com/embed/0bjpJCggyT4', 'php-indonesia-event-jakarta.jpg'),
(13, 3, 'Ask &amp; Question PHP Indonesia Special Event', 'https://www.youtube.com/embed/7VtkbphDtTs', 'php-indonesia-event-jakarta.jpg'),
(14, 3, 'Introducing AKSI IDE Editor on Yii', 'https://www.youtube.com/embed/1wYgIHdGofU', 'php-indonesia-event-jakarta.jpg'),
(15, 3, 'What New on Yii 2', 'https://www.youtube.com/embed/dZpn34rmtzk', 'php-indonesia-event-jakarta.jpg'),
(16, 3, 'Azure Cloud Platform', 'https://www.youtube.com/embed/YgoGkPepxgs', 'php-indonesia-event-jakarta.jpg'),
(17, 3, 'All About PHP Indonesia Community', 'https://www.youtube.com/embed/g93znrO6uaM', 'php-indonesia-event-jakarta.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
