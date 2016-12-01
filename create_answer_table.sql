CREATE TABLE `answer` (
  `exam_name` varchar(50) NOT NULL,
  `question_number` int(11) NOT NULL,
  `s_id` varchar(20) NOT NULL,
  `choice` char(1) NOT NULL,
  `score` int(11) NOT NULL,
  KEY `exam_name` (`exam_name`),
  KEY `question_number` (`question_number`),
  KEY `s_id` (`s_id`),
  CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`exam_name`) REFERENCES `exam` (`exam_name`),
  CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`question_number`) REFERENCES `question` (`question_number`),
  CONSTRAINT `answer_ibfk_3` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`)
);
