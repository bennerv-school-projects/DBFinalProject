CREATE TABLE `choice` (
  `id` char(1) NOT NULL,
  `exam_name` varchar(50) NOT NULL,
  `question_number` int(11) NOT NULL,
  `choice_contents` varchar(256) NOT NULL,
  KEY `exam_name` (`exam_name`),
  KEY `question_number` (`question_number`),
  CONSTRAINT `choice_ibfk_1` FOREIGN KEY (`exam_name`) REFERENCES `exam` (`exam_name`),
  CONSTRAINT `choice_ibfk_2` FOREIGN KEY (`question_number`) REFERENCES `question` (`question_number`)
);
