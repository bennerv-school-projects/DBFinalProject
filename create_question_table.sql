CREATE TABLE question (
  exam_name varchar(50) NOT NULL,
  question_number int(11) NOT NULL,
  answer char(1) NOT NULL,
  points int(11) NOT NULL,
  question_contents varchar(256) NOT NULL,
  PRIMARY KEY (question_number),
  FOREIGN KEY (exam_name) REFERENCES exam (exam_name)
);
