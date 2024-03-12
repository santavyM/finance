-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Úte 12. bře 2024, 10:31
-- Verze serveru: 10.4.25-MariaDB
-- Verze PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `finance`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `calculators`
--

CREATE TABLE `calculators` (
  `id` int(10) UNSIGNED NOT NULL,
  `mortgage` float NOT NULL,
  `rent` float NOT NULL,
  `invest` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `calculators`
--

INSERT INTO `calculators` (`id`, `mortgage`, `rent`, `invest`, `created_at`, `updated_at`) VALUES
(1, 5.99, 2.99, 5.99, '2024-02-11 21:54:29', '2024-02-11 21:54:29');

-- --------------------------------------------------------

--
-- Struktura tabulky `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT 10000,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `categories`
--

INSERT INTO `categories` (`id`, `name`, `ordering`, `created_at`, `updated_at`) VALUES
(8, 'Web Dev.', 2, '2023-11-27 05:29:35', '2024-01-02 15:17:16'),
(10, 'App Dev.', 1, '2023-11-27 16:39:30', '2024-01-01 23:41:01'),
(11, 'PEs', 4, '2024-01-02 13:56:49', '2024-01-07 13:31:11'),
(13, 'Dalajkovi Trable', 3, '2024-01-05 22:03:33', '2024-01-07 13:31:11'),
(14, 'kun', 10000, '2024-01-19 22:14:42', '2024-01-19 22:14:42');

-- --------------------------------------------------------

--
-- Struktura tabulky `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('admin@email.com', '9b57d60afca6a06c5af30125fd6841b5bc36c3f228787bd26e5957cd9bfe5b5136d01cf92b9363b8ca2141a13228e540161d30064e23db10824d2a82e278a83869', '2024-01-08 20:30:40');

-- --------------------------------------------------------

--
-- Struktura tabulky `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `tags` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `visibility` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `category_id`, `title`, `slug`, `content`, `featured_image`, `tags`, `meta_keywords`, `meta_description`, `visibility`, `created_at`, `updated_at`) VALUES
(3, 1, 11, 'WEB DEVELOPEMTN TOOOLS', 'web-developemtn-toools', '<p>cot-info-c onta iner&nbsp; cont act-info- contai ner cont act-info-co n tainer co ntact-info -con tainer&nbsp;c ntact-info container</p>\r\n', 'pimg_17042117701SOL1.jpg', '', '', '', 1, '2024-01-02 16:09:30', '2024-03-09 23:02:41'),
(4, 1, 9, 'WEB 353', 'web-353', '<p>lkjd lkajdlka lkdjas ildjaslkdj lakjd lkasj dlkasdasd a asd asd as</p>\r\n', 'pimg_1704305138Výstřižek.PNG', '', 'POH', 'mam rad koně', 1, '2024-01-03 18:05:38', '2024-01-07 13:34:29'),
(6, 1, 8, 'mám rad koně a prasata :)', 'mam-rad-kone-a-prasata', '<p>mam rad kone a prastaa protze mam rad mistra hrdinu jo prosimte lukas gabriel je milovnik</p>\r\n', 'pimg_1704306853Výstřižek.PNG', 'lukas gay', 'seo lol', '', 1, '2024-01-03 18:34:14', '2024-03-11 22:18:20'),
(7, 1, 8, 'test 353', 'test-353', '<p>In your code snippet, it seems you are trying to retrieve the &#39;name&#39; property of a category object. The error suggests that the object returned by <code>$category-&gt;asObject()-&gt;find($category_id)</code> is not an object or is <code>null</code>, meaning that the category with the specified ID was not found.</p>\r\n\r\n<p>To avoid the error and handle the case where the category is not found, you can check if the object is not null before attempting to access its properties. Here&#39;s an example using an if statement:</p>\r\n', 'pimg_1704307469Výstřižek.PNG', 'test', '', '', 1, '2024-01-03 18:44:29', '2024-01-07 13:34:35'),
(9, 1, 10, 'test 535', 'test-1', '<p>In your code snippet, it seems you are trying to retrieve the &#39;name&#39; property of a category object. The error suggests that the object returned by <code>$category-&gt;asObject()-&gt;find($category_id)</code> is not an object or is <code>null</code>, meaning that the category with the specified ID was not found.</p>\r\n\r\n<p>To avoid the error and handle the case where the category is not found, you can check if the object is not null before attempting to access its properties. Here&#39;s an example using an if statement:</p>\r\n', 'pimg_17043075574335cs_1.jpg', 'tomen', 'post', '', 1, '2024-01-03 18:45:57', '2024-01-07 13:34:38'),
(10, 1, 11, 'test 3535', 'test-3535', '<p>isdojfio sdajfoij sioa fjioj sdiofjois jadiofjiosdaj iofjsidajfkl jsakldfkl jsakl jflkjsjakldj fklsdjaklf jklsadj fsdf&nbsp;</p>\r\n', 'pimg_17043080011.png', 'pero a ja', 'pero a ja', '', 1, '2024-01-03 18:53:21', '2024-01-07 13:34:40'),
(13, 1, 13, 'Jo', 'jo-1', '<p><strong>orem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n\r\n<p><strong>orem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n', 'pimg_17044921836256670_v0.jpg', 'Martin', 'Martin', 'TOTO TADY JE UPLNE K PICI', 1, '2024-01-05 22:03:03', '2024-01-21 09:26:25'),
(15, 1, 11, 'čau já jsem Petčerko sssšekšš', 'cau-ja-jsem-petcerko-ssssekss', '<p>kshjf kljafkl jasdklfjasd klfjasdlk fsadf a</p>\r\n', 'pimg_171019499110.jpg', 'Petr', '', '', 1, '2024-03-11 22:09:51', '2024-03-11 22:17:58');

-- --------------------------------------------------------

--
-- Struktura tabulky `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_email` varchar(255) NOT NULL,
  `blog_phone` varchar(255) DEFAULT NULL,
  `blog_meta_keywords` varchar(255) DEFAULT NULL,
  `blog_meta_description` text DEFAULT NULL,
  `blog_logo` varchar(255) DEFAULT NULL,
  `blog_favicon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `settings`
--

INSERT INTO `settings` (`id`, `blog_title`, `blog_email`, `blog_phone`, `blog_meta_keywords`, `blog_meta_description`, `blog_logo`, `blog_favicon`, `created_at`, `updated_at`) VALUES
(1, 'Finance', 'martin.santavy@email.cz', '+420 608 310 071', 'finance, kalkulacky', 'popis webu pro SEO', 'CI4blog_logo1709478458_21d890ea96bbe0803a7f.jpg', 'favicon_1704491956_c9081253d65b9a456dee.png', '2024-01-02 16:09:30', '2024-03-03 15:07:38');

-- --------------------------------------------------------

--
-- Struktura tabulky `social_media`
--

CREATE TABLE `social_media` (
  `id` int(10) UNSIGNED NOT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `social_media`
--

INSERT INTO `social_media` (`id`, `facebook_url`, `twitter_url`, `instagram_url`, `youtube_url`, `github_url`, `linkedin_url`, `created_at`, `updated_at`) VALUES
(1, 'https://facebook.com/mtes', '', '', 'https://youtube.com/@fortnite', 'https://github.com/santavyM', 'https://facebook.com', '2023-12-28 12:05:41', '2024-02-12 19:41:26');

-- --------------------------------------------------------

--
-- Struktura tabulky `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `theme_name` varchar(255) NOT NULL,
  `theme_file` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `themes`
--

INSERT INTO `themes` (`id`, `user_id`, `theme_name`, `theme_file`, `active`) VALUES
(3, 1, 'default', 'default.css', 0),
(4, 1, 'Normal', 'style1.less', 1),
(5, 1, 'Funny', 'style2.less', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `picture`, `bio`, `created_at`, `updated_at`) VALUES
(1, 'Martin Santavy', 'admin', 'admin@email.com', '$2y$10$gLO4BvYhlXzqO/dV2WjFVuj0VmE6Gjo2MxcvpnZfsBQLsyXwYd6fS', 'UIMG_11710192851_d52c08a9ad489f15cf46.png', '', '2023-12-26 20:58:34', '2024-03-11 21:34:11');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `calculators`
--
ALTER TABLE `calculators`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `categories`
--
ALTER TABLE `categories`
  ADD KEY `id` (`id`);

--
-- Indexy pro tabulku `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexy pro tabulku `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexy pro tabulku `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `calculators`
--
ALTER TABLE `calculators`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pro tabulku `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pro tabulku `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
