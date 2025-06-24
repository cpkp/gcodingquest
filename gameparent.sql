
    CREATE TABLE teacher (
    teacher_id VARCHAR(255) PRIMARY KEY ,
    name VARCHAR(100),
    password VARCHAR(255),
    department VARCHAR(100),
    action INT
);



-- Create the student table
CREATE TABLE student (
    student_id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(100),
    password VARCHAR(255),
    child_code VARCHAR(50) UNIQUE
);

-- Create a trigger to enforce that the child_code can only be updated once
DELIMITER //
CREATE TRIGGER before_student_update
BEFORE UPDATE ON student
FOR EACH ROW
BEGIN
    IF OLD.child_code IS NOT NULL AND NEW.child_code IS NOT NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot update child_code more than once';
    END IF;
   
END //
DELIMITER ;
-- Create the parent table
CREATE TABLE parent (
    parent_id VARCHAR(255) PRIMARY KEY,
    parent_name VARCHAR(100),
    password VARCHAR(255),
    parent_code VARCHAR(50) UNIQUE
);

-- Create a trigger to enforce that the parent_code can only be updated once
DELIMITER //
CREATE TRIGGER before_parent_update
BEFORE UPDATE ON parent
FOR EACH ROW
BEGIN
    IF OLD.parent_code IS NOT NULL AND NEW.parent_code IS NOT NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot update parent_code more than once';
    END IF;
    
END //
DELIMITER ;
CREATE TABLE gamescore (
    score_id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT,
    course_id INT,
    score DECIMAL(10, 2),
    student_id VARCHAR(255),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_lesson
        FOREIGN KEY (lesson_id)
        REFERENCES lessons(id)
        ON DELETE CASCADE, -- If a lesson is deleted, delete the corresponding game scores
    CONSTRAINT fk_course
        FOREIGN KEY (course_id)
        REFERENCES courses(id)
        ON DELETE CASCADE, -- If a course is deleted, delete the corresponding game scores
    CONSTRAINT fk_user
        FOREIGN KEY (student_id)
        REFERENCES student(student_id)
        ON DELETE CASCADE -- If a user is deleted, delete the corresponding game scores
);

-- Create the relation table
CREATE TABLE relation (
    relation_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(255),
    parent_id VARCHAR(255),
    child_code VARCHAR(50),
    parent_code VARCHAR(50),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_code) REFERENCES parent(parent_code),
    FOREIGN KEY (child_code) REFERENCES student(child_code),
    FOREIGN KEY (student_id) REFERENCES student(student_id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES parent(parent_id) ON DELETE CASCADE
);

-- Remove invalid rows from the relation table
DELETE FROM relation WHERE student_id NOT IN (SELECT student_id FROM student);
DELETE FROM relation WHERE parent_id NOT IN (SELECT parent_id FROM parent);