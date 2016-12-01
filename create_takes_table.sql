CREATE TABLE takes (
  s_id varchar(20) NOT NULL,
  exam_name varchar(50) NOT NULL,
  student_score int(11) NOT NULL,
  FOREIGN KEY (s_id) REFERENCES student (s_id),
  FOREIGN KEY (exam_name) REFERENCES exam (exam_name)
);
