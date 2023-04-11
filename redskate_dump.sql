-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 11 2023 г., 13:37
-- Версия сервера: 10.8.4-MariaDB
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `redskate`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `preview` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id_category`, `name`, `preview`) VALUES
(1, 'Скейтборды в сборе', '1.png'),
(2, 'Деки', '2.png'),
(3, 'Шкурка', '3.png'),
(4, 'Подвески', '4.png'),
(5, 'Колеса', '5.png'),
(6, 'Чехлы и рюкзаки', '6.png'),
(7, 'Инструменты', '7.png'),
(8, 'Подшипники', '8.png');

-- --------------------------------------------------------

--
-- Структура таблицы `favourites`
--

CREATE TABLE `favourites` (
  `id_favourite` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `favourites`
--

INSERT INTO `favourites` (`id_favourite`, `id_user`, `id_product`) VALUES
(16, 14, 7),
(31, 16, 6),
(36, 21, 11);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_order_status` int(11) NOT NULL,
  `id_order_delivery_method` int(11) NOT NULL,
  `id_order_pay_method` int(11) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `address` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `id_order_status`, `id_order_delivery_method`, `id_order_pay_method`, `phone`, `email`, `address`) VALUES
(12, 12, 4, 2, 1, '+83493200092', 'testf@fsdf.ti', '632606, Пензенская область, город Озёры, спуск Чехова, 24'),
(13, 15, 5, 1, 1, '298314732894', 'FSDIJ@SDJFK', ''),
(14, 15, 1, 1, 1, '23847324897', 'jkalkdjsadlk@jdaj', ''),
(15, 19, 5, 1, 1, '123', 'isip_m.ya.dobrovolosky@mpt.ru', ''),
(16, 19, 1, 1, 1, '23847324897', 'jkalkdjsadlk@jdaj', ''),
(17, 19, 5, 1, 1, '23847324897', 'jkalkdjsadlk@jdaj', ''),
(18, 20, 5, 1, 1, '+79250430688', 'fenn3crfox@gmail.com', ''),
(19, 18, 1, 1, 1, '+7 (234) 234-23-43', 'jkalkdjsadlk@jdaj.ri', '');

-- --------------------------------------------------------

--
-- Структура таблицы `order_delivery_method`
--

CREATE TABLE `order_delivery_method` (
  `id_order_delivery_method` int(11) NOT NULL,
  `method` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `order_delivery_method`
--

INSERT INTO `order_delivery_method` (`id_order_delivery_method`, `method`) VALUES
(1, 'Самовывоз'),
(2, 'Доставка');

-- --------------------------------------------------------

--
-- Структура таблицы `order_pay_methods`
--

CREATE TABLE `order_pay_methods` (
  `id_order_pay_method` int(11) NOT NULL,
  `method` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `order_pay_methods`
--

INSERT INTO `order_pay_methods` (`id_order_pay_method`, `method`) VALUES
(1, 'При получении'),
(2, 'Онлайн');

-- --------------------------------------------------------

--
-- Структура таблицы `order_products`
--

CREATE TABLE `order_products` (
  `id_order_product` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `final_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `order_products`
--

INSERT INTO `order_products` (`id_order_product`, `id_order`, `id_product`, `count`, `final_price`) VALUES
(12, 12, 12, 1, 5243),
(13, 12, 17, 2, 1890),
(14, 13, 7, 2, 8050),
(15, 14, 9, 1, 8050),
(16, 14, 11, 2, 5243),
(17, 15, 6, 2, 5243),
(18, 16, 6, 2, 5243),
(19, 16, 7, 3, 8050),
(22, 18, 6, 2, 5243),
(23, 19, 10, 1, 5243);

-- --------------------------------------------------------

--
-- Структура таблицы `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id_order_status` int(11) NOT NULL,
  `status` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `order_statuses`
--

INSERT INTO `order_statuses` (`id_order_status`, `status`) VALUES
(1, 'CREATED'),
(2, 'ACCEPTED'),
(3, 'WAITING_FOR_RECEIPT'),
(4, 'DELIVERY'),
(5, 'COMPLETED');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `price` int(11) NOT NULL,
  `old_price` int(11) DEFAULT NULL,
  `description` varchar(1024) NOT NULL,
  `preview` varchar(256) NOT NULL,
  `color` varchar(7) NOT NULL,
  `id_category` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `new` tinyint(1) NOT NULL,
  `bestseller` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id_product`, `name`, `price`, `old_price`, `description`, `preview`, `color`, `id_category`, `count`, `new`, `bestseller`) VALUES
(6, 'Скейтборд в сборе Footwork F1 8”', 5243, 7490, 'Бренд: Footwork\r\nБренд: Footwork\r\n-Доска Footwork F1 8” X 31.5”, средний конкейв\r\n-Наждак Footwork Classic Black\r\n-Подвески Footwork (НОВАЯ ФОРМУЛА БУШИНГОВ - БЫСТРЫЙ ОТКЛИК)\r\n-Колеса Footwork 53 mm 99A\r\n-Подшипники Footwork ABEC5\r\n-Винты Footwork\r\n\r\nКЕПКА, ПЛАКАТ И СТИКЕР В ПОДАРОК', '640c6ccf01454.png', '#fd8383', 1, 0, 0, 1),
(7, 'Скейтборд в сборе CHOCOLATE PEREZ VANNER', 8050, 13490, 'Скейтборд в сборе:\r\nШирина деки: 8.25\r\nКолёса: 52 мм, жёсткость 100А\r\nПодшипники: Abec 5\r\n7 слоёв канадского клёна', '640c6d5fd2d97.png', '#ffcb5c', 1, 12, 0, 1),
(8, 'Скейтборд в сборе Footwork Drew Black 8”', 5243, 7490, 'Бренд: Footwork\r\n-Доска Footwork Drew Black 8” X 31.5”, средний конкейв\r\n-Наждак Footwork Classic Black\r\n-Подвески Footwork (НОВАЯ ФОРМУЛА БУШИНГОВ - БЫСТРЫЙ ОТКЛИК)\r\n-Колеса Footwork 53 mm 99A\r\n-Подшипники Footwork ABEC5\r\n-Винты Footwork\r\n\r\nКЕПКА, ПЛАКАТ И СТИКЕР В ПОДАРОК', '640c6f34b1a10.png', '#f0ff24', 1, 0, 0, 1),
(9, 'Скейтборд в сборе CHOCOLATE TERSHY BIKE', 8050, 13490, 'Поставка: Сентябрь 2022\r\n \r\nСкейтборд в сборе:\r\nШирина деки: 8.125\r\nКолёса: 52 мм, жёсткость 99А\r\nПодшипники: Abec 5\r\n7 слоёв канадского клёна', '640c7072ecd64.png', '#468967', 1, 4, 0, 1),
(10, 'Скейтборд в сборе Footwork Bandana 8”', 5243, 7490, 'Бренд: Footwork\r\n-Доска Footwork Bandana 8” X 31.5”, краска металлик, средний конкейв\r\n-Наждак Footwork Classic Black\r\n-Подвески Footwork (НОВАЯ ФОРМУЛА БУШИНГОВ - БЫСТРЫЙ ОТКЛИК)\r\n-Колеса Footwork 53 mm 99A\r\n-Подшипники Footwork ABEC5\r\n-Винты Footwork\r\n\r\nКЕПКА, ПЛАКАТ И СТИКЕР В ПОДАРОК', '640c71ca0a718.png', '#835e9c', 1, 13, 0, 1),
(11, 'Скейтборд в сборе Footwork Bubble 8”', 5243, 7490, 'Бренд: Footwork\r\n-Доска Footwork Bubble 8” X 31.5”, средний конкейв\r\n-Наждак Footwork Classic Black\r\n-Подвески Footwork (НОВАЯ ФОРМУЛА БУШИНГОВ - БЫСТРЫЙ ОТКЛИК)\r\n-Колеса Footwork 53 mm 99A\r\n-Подшипники Footwork ABEC5\r\n-Винты Footwork\r\n\r\nКЕПКА, ПЛАКАТ И СТИКЕР В ПОДАРОК', '640c72d12a2ff.png', '#00d5ff', 1, 11, 0, 1),
(12, 'Скейтборд в сборе Footwork Waves 8”', 5243, 7490, 'Бренд: Footwork\r\n-Доска Footwork Waves 8” X 31.5”, глубокий конкейв\r\n-Наждак Footwork Classic Black\r\n-Подвески Footwork (НОВАЯ ФОРМУЛА БУШИНГОВ - БЫСТРЫЙ ОТКЛИК)\r\n-Колеса Footwork 53 mm 99A\r\n-Подшипники Footwork ABEC5\r\n-Винты Footwork\r\n\r\nКЕПКА, ПЛАКАТ И СТИКЕР В ПОДАРОК', '640c7404eca9d.png', '#00f590', 1, 14, 0, 1),
(13, 'Скейтборд в сборе Footwork Scorpion 8”', 5243, 7490, 'Бренд: Footwork\r\n-Доска Footwork Scorpion 8” X 31.5”, средний конкейв\r\n-Наждак Footwork Classic Black\r\n-Подвески Footwork (НОВАЯ ФОРМУЛА БУШИНГОВ - БЫСТРЫЙ ОТКЛИК)\r\n-Колеса Footwork 53 mm 99A\r\n-Подшипники Footwork ABEC5\r\n-Винты Footwork\r\n\r\nКЕПКА, ПЛАКАТ И СТИКЕР В ПОДАРОК', '640c753b06eb1.png', '#e5fff9', 1, 5, 0, 1),
(14, 'Скейтборд в сборе CHOCOLATE ALVAREZ CHUNK 7', 5900, 8450, 'Коллекция 2021\r\n\r\nДека про-модель: Vincent Alvarez\r\nРазмер: 7.75\" x 31.125\"\r\nКолёса: 52 мм\r\nПодшипники: Abec 5\r\n100% канадский клён, железо, полиуретан, наждачное покрытие', '640c7657b6358.png', '#729ae9', 1, 3, 1, 0),
(15, 'Комплект подвесок Ace Classic', 4580, NULL, 'Бренд: ACE\r\nСамые популярные и любимые подвески в мире, теперь в нашем магазине. Великолепная геометрия, отличные повороты и отклик. Именно на подвесках ACE катается наш про Миша Степанов! Посмотрите как плавно он катается в боулах и плазах на этих подвесках, и вам сразу станет понятно как отлично они работают.', '640c775739404.png', '#a9d5fe', 4, 7, 1, 0),
(16, 'Комплект подвесок Ace AF1 Satin Lime', 6500, NULL, 'Бренд: ACE\r\nСамые популярные и любимые подвески в мире, теперь в нашем магазине. Новая модель AF1 на 70% крепче классической модели. В настоящее время эти подвески являются самыми крепкими в мире. Великолепная геометрия, отличные повороты и отклик. Именно на подвесках ACE катается наш про Миша Степанов! Посмотрите как плавно он катается в боулах и плазах на этих подвесках, и вам сразу станет понятно как отлично они работают.', '640c78c72dfca.png', '#ffea80', 4, 3, 1, 0),
(17, 'Комплект колес Footwork Barber Shop 78A', 1890, NULL, 'Бренд: Footwork\r\nЖесткость: 78A (мягкие)\r\nЦветной полупрозрачный полиуретан\r\n\r\nКлассическая форма колес для круизеров и лонгбордов. Мягкие и комфортные, сделают из любой доски круизер для передвижения по городу.', '640c79af19029.png', '#fea9ad', 5, 5, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `product_images`
--

CREATE TABLE `product_images` (
  `id_product_image` int(11) NOT NULL,
  `image` varchar(256) NOT NULL,
  `id_product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `product_images`
--

INSERT INTO `product_images` (`id_product_image`, `image`, `id_product`) VALUES
(10, '640c6ccf018a3.jpg', 6),
(11, '640c6ccf01c1a.jpg', 6),
(12, '640c6ccf024dc.jpg', 6),
(13, '640c6ccf02f78.jpg', 6),
(14, '640c6d5fd4aaf.jpeg', 7),
(15, '640c6d5fd5ac2.jpeg', 7),
(16, '640c6d5fd5d41.png', 7),
(17, '640c6f34b1ddf.jpg', 8),
(18, '640c6f34b22e3.jpg', 8),
(19, '640c6f34b2d7c.jpg', 8),
(20, '640c7072ed1b1.jpeg', 9),
(21, '640c7072ed545.jpeg', 9),
(22, '640c7072edcdb.jpeg', 9),
(23, '640c7072ee455.jpeg', 9),
(24, '640c7072eebf7.jpeg', 9),
(25, '640c71ca0aba5.jpg', 10),
(26, '640c71ca0b12a.jpg', 10),
(27, '640c71ca0be6e.jpg', 10),
(28, '640c71ca1014b.jpg', 10),
(29, '640c72d12a94a.jpg', 11),
(30, '640c72d12aeb8.jpg', 11),
(31, '640c72d12b583.jpg', 11),
(32, '640c72d12c0aa.jpg', 11),
(33, '640c72d12ef91.jpg', 11),
(34, '640c7404ecf72.jpg', 12),
(35, '640c7404ed3b3.jpg', 12),
(36, '640c7404ed7fa.jpg', 12),
(37, '640c7404ee0fe.jpg', 12),
(38, '640c7404f0319.jpg', 12),
(39, '640c753b07232.jpg', 13),
(40, '640c753b0752c.jpg', 13),
(41, '640c753b08037.jpg', 13),
(42, '640c753b08723.jpg', 13),
(43, '640c7657b6812.jpg', 14),
(44, '640c7657b6a83.jpeg', 14),
(45, '640c7657b6cc0.jpg', 14),
(46, '640c775739876.jpg', 15),
(47, '640c77573a7c3.jpg', 15),
(48, '640c77573b6b7.jpg', 15),
(49, '640c77573c3d1.jpg', 15),
(50, '640c77573cd9f.jpg', 15),
(51, '640c78c72e35b.jpg', 16),
(52, '640c78c72e65c.jpg', 16),
(53, '640c78c72ed6d.jpg', 16),
(54, '640c78c730183.jpg', 16),
(55, '640c78c730836.jpg', 16),
(56, '640c79af193dd.jpg', 17),
(57, '640c79af19cc6.jpg', 17),
(58, '640c79af1a310.jpg', 17);

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id_review` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `time` date NOT NULL DEFAULT current_timestamp(),
  `text` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id_review`, `id_user`, `id_product`, `rating`, `time`, `text`) VALUES
(6, 12, 12, 5, '2023-03-11', 'Очень крутой скейт, крутой принт, однозначно лайк'),
(7, 12, 17, 5, '2023-03-11', 'Колеса супер :-)'),
(8, 15, 7, 5, '2023-03-12', 'Крутой скейт, спасибо!'),
(10, 19, 6, 5, '2023-03-15', 'Спасибо за крутицкий скейт, я доволен!');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL,
  `pfp` varchar(256) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `permissions` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `name`, `email`, `phone`, `address`, `pfp`, `password`, `permissions`) VALUES
(1, 'test', 'test', 'test', 'test', '', 'test', 0),
(2, 'Гость-4728', NULL, NULL, NULL, NULL, NULL, 0),
(3, 'Гость-7461', NULL, NULL, NULL, NULL, NULL, 0),
(4, 'Гость-2793', NULL, NULL, NULL, NULL, NULL, 0),
(5, 'Гость-6903', NULL, NULL, NULL, NULL, NULL, 0),
(6, 'sdf', 'sf@sf', NULL, NULL, NULL, '$2y$10$FY0YgU5Lruwx9DwJzHEfku1ZBRfDy78yQFn6vmO6uIjDGL8qkvaVm', 0),
(7, 'Gektor Salamanca', 'gektor@cartel.mx', '', '', '6408c54286abc.jpg', '$2y$10$Z9BVfHd7FqeZZcTYgEwwBuS8dLN5l5ecPp.C1USzbQ2jzeBo4gXOq', 0),
(8, 'he', 'sd@md', NULL, NULL, NULL, '$2y$10$hX5xfobOELPUuTk.O2nm/u1yaD8vxSiqUdT6rvAZW5fnmuWJd//P.', 0),
(9, 'dsf', 'sdf@sd', NULL, NULL, NULL, '$2y$10$vFt6fifkE7K7qQXOlMI5yue1fZEg0cxfLMJYTSqOxG/OtE6BXAlRm', 0),
(10, 'asdasd', 'ghfas@asdj', '231123123', 'asdsad', '6408c7886edda.jpg', '$2y$10$zFNs.fSdnP.nRfSsI3pdp.jD/51vcsVEeW1AFF7MpfEbXieseAh3q', 0),
(12, 'Гость-7790', NULL, NULL, NULL, NULL, NULL, 0),
(13, 'Гость-2697', NULL, NULL, NULL, NULL, NULL, 0),
(14, 'Гость-7350', NULL, NULL, NULL, NULL, NULL, 0),
(15, 'Гость-2954', NULL, NULL, NULL, NULL, NULL, 0),
(16, 'Гость-9687', NULL, NULL, NULL, NULL, NULL, 0),
(17, 'meme', 'meme@meme', NULL, NULL, NULL, '$2y$10$/YRIyEBLq7mRnj1v5p/woumSdANlzknaDnJlXolh.s/CpJWQ0KoNu', 0),
(18, 'Admin', 'admin@admin.admin', '+7(324) 242-34-33', '', '6410eefeab5cd.png', '$2y$10$M37nRXFPSfmwBRCjIoDdM.G58LDhq47dpOGDw1mfltr6srFz37/Rm', 2),
(19, 'Крутой юзер :)', 'a@b.c', '', '', '6411658c26941.jpg', '$2y$10$mjbhoYbG1UtO9sdyHtphjOPnFnRDNMHZTk.Kccr2pNGWaAJT2mrJi', 0),
(20, 'test1', 'test1@mail.ru', '+7(324) 242-34-33', 'улица 123', '64118e0f42b36.jpg', '$2y$10$.Bu6fVdD4JXWWpnyf7R9EuiDBSzOfbaAwhumjFipq9o.GTpT67NFK', 0),
(21, 'Гость-6804', NULL, NULL, NULL, NULL, NULL, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `cart_ibfk_2` (`id_user`),
  ADD KEY `cart_ibfk_3` (`id_product`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Индексы таблицы `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id_favourite`),
  ADD KEY `favourites_ibfk_1` (`id_product`),
  ADD KEY `favourites_ibfk_2` (`id_user`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `status` (`id_order_status`),
  ADD KEY `id_order_delivery_method` (`id_order_delivery_method`),
  ADD KEY `id_order_pay_method` (`id_order_pay_method`);

--
-- Индексы таблицы `order_delivery_method`
--
ALTER TABLE `order_delivery_method`
  ADD PRIMARY KEY (`id_order_delivery_method`);

--
-- Индексы таблицы `order_pay_methods`
--
ALTER TABLE `order_pay_methods`
  ADD PRIMARY KEY (`id_order_pay_method`);

--
-- Индексы таблицы `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id_order_product`),
  ADD KEY `order_products_ibfk_1` (`id_order`),
  ADD KEY `order_products_ibfk_2` (`id_product`);

--
-- Индексы таблицы `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id_order_status`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_category` (`id_category`);

--
-- Индексы таблицы `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id_product_image`),
  ADD KEY `product_images_ibfk_1` (`id_product`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `reviews_ibfk_1` (`id_product`),
  ADD KEY `reviews_ibfk_2` (`id_user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id_favourite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `order_delivery_method`
--
ALTER TABLE `order_delivery_method`
  MODIFY `id_order_delivery_method` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `order_pay_methods`
--
ALTER TABLE `order_pay_methods`
  MODIFY `id_order_pay_method` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id_order_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id_order_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id_product_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE,
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`id_order_status`) REFERENCES `order_statuses` (`id_order_status`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`id_order_delivery_method`) REFERENCES `order_delivery_method` (`id_order_delivery_method`),
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`id_order_pay_method`) REFERENCES `order_pay_methods` (`id_order_pay_method`);

--
-- Ограничения внешнего ключа таблицы `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`);

--
-- Ограничения внешнего ключа таблицы `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
