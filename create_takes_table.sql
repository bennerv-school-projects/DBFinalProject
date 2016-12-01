CREATE TABLE `takes` (
  `s_id` varchar(20) NOT NULL,
  `exam_name` varchar(50) NOT NULL,
  `student_score` int(11) NOT NULL,
  KEY `s_id` (`s_id`),
  KEY `exam_name` (`exam_name`),
  CONSTRAINT `takes_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`),
  CONSTRAINT `takes_ibfk_2` FOREIGN KEY (`exam_name`) REFERENCES `exam` (`exam_name`)
);
