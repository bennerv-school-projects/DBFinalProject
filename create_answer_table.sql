CREATE TABLE answer (
  exam_name varchar(50) NOT NULL,
  question_number int(11) NOT NULL,
  s_id varchar(20) NOT NULL,
  choice char(1) NOT NULL,
  score int(11) NOT NULL,
  FOREIGN KEY (exam_name) REFERENCES exam (exam_name),
  FOREIGN KEY (question_number) REFERENCES question (question_number),
  FOREIGN KEY (s_id) REFERENCES student (s_id)
);
