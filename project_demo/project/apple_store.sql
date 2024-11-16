-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.2
-- Время создания: Ноя 16 2024 г., 23:32
-- Версия сервера: 8.2.0
-- Версия PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `apple_store`
--

-- --------------------------------------------------------

--
-- Структура таблицы `apple_varieties`
--

CREATE TABLE `apple_varieties` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `apple_varieties`
--

INSERT INTO `apple_varieties` (`id`, `name`) VALUES
(8, 'asd'),
(1, 'test1'),
(10, 'wewe'),
(6, 'апуфыв'),
(4, 'мак'),
(3, 'нак'),
(5, 'сак'),
(7, 'фыв'),
(2, 'яблкр');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `apple_variety_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `status` enum('new','confirmed','rejected') DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `apple_variety_id`, `quantity`, `status`) VALUES
(1, 3, 1, 24, 'confirmed'),
(2, 3, 3, 45, 'new'),
(3, 3, 2, 35, 'new'),
(4, 3, 3, 3, 'confirmed');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `full_name`, `phone`, `email`, `login`, `password`, `role`, `created_at`) VALUES
(1, 'test', '123', 'test@test', '123', '$2y$10$8qLCFgcdM6SpVs/tWMgvH.l92M0X3rLYW2JT0y0CLQoVyK1st7YGW', 'user', '2024-11-16 17:49:15'),
(2, 'test123', '123', 'test@test23', 'test1', '$2y$10$emnyqRNeIiKE9l827C9LyuQpec7TPzZuwHSAt9SHP1H0M6ZVuwA3y', 'admin', '2024-11-16 17:50:06'),
(3, 'asd', '232', 'test23@23', 'test', '$2y$10$2BGyOue9JnrA6WujKzTPredUmXDA8LzaHPxTqtfDRmdn0brDk1ID6', 'user', '2024-11-16 18:03:07');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `apple_varieties`
--
ALTER TABLE `apple_varieties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `apple_variety_id` (`apple_variety_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `apple_varieties`
--
ALTER TABLE `apple_varieties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`apple_variety_id`) REFERENCES `apple_varieties` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
