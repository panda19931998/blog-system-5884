--
-- テーブルの構造 `blog`
--

CREATE TABLE `blog` (
  `id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `blog_title` varchar(100) COLLATE utf8_bin NOT NULL,
  `blog_description` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `blog_keywords` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `blog_author_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `blog_header_image` mediumblob,
  `blog_header_image_ext` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `blog_favicon_image` mediumblob,
  `blog_favicon_image_ext` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `blog_favicon180_image` mediumblob,
  `blog_favicon180_image_ext` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `blog_default_eye_catch_image` mediumblob,
  `blog_default_eye_catch_image_ext` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `analytics_ua_code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `blog_entry`
--

CREATE TABLE `blog_entry` (
  `id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `blog_id` bigint(20) NOT NULL,
  `blog_entry_code` bigint(20) NOT NULL,
  `title` varchar(200) COLLATE utf8_bin NOT NULL,
  `contents` mediumtext COLLATE utf8_bin,
  `posting_date` datetime NOT NULL,
  `seo_title` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `seo_description` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `seo_keywords` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `slug` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `eye_catch_image` mediumblob,
  `eye_catch_image_ext` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `view_count` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `blog_entry_image`
--

CREATE TABLE `blog_entry_image` (
  `id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `blog_id` bigint(20) NOT NULL,
  `blog_entry_id` bigint(20) NOT NULL,
  `image_code` varchar(16) COLLATE utf8_bin NOT NULL,
  `image` mediumblob NOT NULL,
  `image_ext` varchar(10) COLLATE utf8_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `blog_category_master`
--

CREATE TABLE `blog_category_master` (
  `id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `blog_id` bigint(20) NOT NULL,
  `blog_category_code` bigint(20) NOT NULL,
  `blog_category_slug` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `category_name` varchar(200) COLLATE utf8_bin NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `blog_category`
--

CREATE TABLE `blog_category` (
  `id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `blog_id` bigint(20) NOT NULL,
  `blog_entry_id` bigint(20) NOT NULL,
  `blog_category_master_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `client`
--

CREATE TABLE `client` (
  `id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `client_code` varchar(12) COLLATE utf8_bin NOT NULL,
  `client_name` varchar(400) COLLATE utf8_bin NOT NULL,
  `mail_address` varchar(500) COLLATE utf8_bin NOT NULL,
  `password` varchar(60) COLLATE utf8_bin NOT NULL,
  `client_profile` mediumtext COLLATE utf8_bin,
  `client_profile_image` mediumblob,
  `client_profile_image_ext` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `client_copyright` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `client_auto_login`
--

CREATE TABLE `client_auto_login` (
  `id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `c_key` varchar(40) COLLATE utf8_bin NOT NULL,
  `expire` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `blog_entry_code_sequence`
--

CREATE TABLE `blog_entry_code_sequence` (
  `id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `blog_id` bigint(20) NOT NULL,
  `sequence` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `blog_category_code_sequence`
--

CREATE TABLE `blog_category_code_sequence` (
  `id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `blog_id` bigint(20) NOT NULL,
  `sequence` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_entry`
--
ALTER TABLE `blog_entry`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_entry_image`
--
ALTER TABLE `blog_entry_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_category_master`
--
ALTER TABLE `blog_category_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_category`
--
ALTER TABLE `blog_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_entry_code_sequence`
--
ALTER TABLE `blog_entry_code_sequence`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_category_code_sequence`
--
ALTER TABLE `blog_category_code_sequence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_auto_login`
--
ALTER TABLE `client_auto_login`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_entry`
--
ALTER TABLE `blog_entry`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_entry_image`
--
ALTER TABLE `blog_entry_image`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_category_master`
--
ALTER TABLE `blog_category_master`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_category`
--
ALTER TABLE `blog_category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_entry_code_sequence`
--
ALTER TABLE `blog_entry_code_sequence`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_category_code_sequence`
--
ALTER TABLE `blog_category_code_sequence`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_auto_login`
--
ALTER TABLE `client_auto_login`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
