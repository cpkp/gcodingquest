CREATE TABLE lessons (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT NOT NULL,
  lesson_name VARCHAR(255) NOT NULL,
  description TEXT,
  thumbnail VARCHAR(255) NOT NULL,
  lesson_folder VARCHAR(255) NOT NULL,
  creator_name VARCHAR(255) NOT NULL,
  max_score INT NOT NULL,
  FOREIGN KEY (course_id) REFERENCES courses(id)
);
