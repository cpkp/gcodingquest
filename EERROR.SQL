ALTER TABLE `lessons`
  ADD COLUMN `creator_id` varchar(255) NOT NULL AFTER `lesson_folder`;