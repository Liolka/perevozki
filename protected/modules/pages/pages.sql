-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 10 2015 г., 14:54
-- Версия сервера: 5.5.36-cll-lve
-- Версия PHP: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `sturboby_yii`
--

-- --------------------------------------------------------

--
-- Структура таблицы `3hnspc_pages`
--

CREATE TABLE IF NOT EXISTS `3hnspc_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `3hnspc_pages`
--

INSERT INTO `3hnspc_pages` (`id`, `name`, `alias`, `text`, `meta_title`, `meta_keywords`, `meta_description`) VALUES
(1, 'Тест стр', 'test-str', 'фвфыв<br />\r\nфывфыв<img alt="" src="/uploads/images/turbo2.jpg" style="height:133px; width:200px" /><br />\r\nукеуе34е<br />\r\n&nbsp;', '', '', ''),
(2, 'О нас', 'o-nas', '<p>S-Turbo.BY –&nbsp; <strong>уникальный</strong> на белорусском профессиональном пространстве проект с перспективой роста до крупнейшего в РБ портала специалистов и любителей автотюнинга. В отличие от других подобных тюнинг – магазинов, S-Turbo.BY это беспрецедентный проект, который объединяет в себе сразу несколько видов деятельности.</p>\r\n<p><strong>•&nbsp;&nbsp; &nbsp;Интернет - магазин тюнинга</strong><br>Это основная и самая важная часть нашей работы. Мы продаем автоаксессуары для тюнинга от лучших мировых&nbsp; производителей и с каждым днем наш ассортимент неуклонно растет. Наша цель -&nbsp; обеспечить достойный выбор товаров по каждому наименованию. Поскольку магазин работает без посредников, цены у нас самые лояльные. Мы работаем по всей Беларуси, поэтому нет необходимости искать <strong>другие тюнинг - магазины&nbsp; в Минске</strong> или другом городе! Товар будет доставлен нашим курьером прямо к порогу вашего дома в любую точку страны.<br>Также вы сможете посмотреть какие компании оказывают <a href="/companyes.html?regions=&amp;city=&amp;comments=&amp;section=48%2C49%2C50%2C51%2C52%2C53%2C54%2C55%2C56%2C57%2C58%2C59%2C60%2C61%2C62%2C63%2C64&amp;section_name=%D0%A1%D0%A2%D0%9E#sideLeft">услуги по ремонту авто</a>.</p>\r\n<p><strong>•&nbsp;&nbsp; &nbsp; Каталог автокомпаний<br>Тюнинг - магазин</strong> S-Turbo.BY это еще и отличная рекламная площадка для успешного развития вашего бизнеса. Компаниям, оказывающим различные автомобильные услуги, мы предлагаем ярко заявить о себе на нашем сайте и в группе Вконтакте. Подробнее о возможностях S-Turbo читайте <a target="_blank" href="/dobavit-svoyu-uslugu.html"><strong>здесь</strong></a>.</p>\r\n<p><strong>•&nbsp;&nbsp; &nbsp; Клуб/форум</strong><br>Ну и наконец, S-Turbo.BY это большое интернет-сообщество любителей тюнинга автомобилей. На базе портала действует клуб и форум, где обсуждаются&nbsp; самые интересные и актуальные автотемы. Стать членом нашего дружного клуба может каждый, пройдя предварительную регистрацию. Участники клуба получают возможность задавать на форуме вопросы профессионалам в сфере тюнинга, оставлять свои отзывы об услугах компаний, участвовать в закрытых встречах клуба, получать приятные скидки на товары и многие&nbsp; другие бонусы!</p>\r\n<p><strong>Будем рады видеть вас в числе наших клиентов и партнеров!</strong></p>', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
