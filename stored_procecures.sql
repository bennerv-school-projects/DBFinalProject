# Set the delimiter
delimiter //

DROP PROCEDURE IF EXISTS create_exam;
DROP PROCEDURE IF EXISTS create_question;


# Create procedure for the exam table to create a new exam
CREATE PROCEDURE create_exam(
  in exam_name varchar(50), 
  in total_points integer)
begin 
  if CHAR_LENGTH(exam_name) > 0 then 
    insert into exam values(exam_name, total_points, CURRENT_DATE());
  end if;
end//

# Create procedure for the question table to create a question for an exam
CREATE PROCEDURE create_question(
  in exam_name varchar(50),
  in question_number integer,
  in answer char(1),
  in points integer,
  in question_contents varchar(256)
)

BEGIN
  declare numOfExams integer;
  declare questionNumber integer;
  
  select COUNT(*) into numOfExams FROM exam where exam.exam_name=exam_name;
  select COUNT(*) into questionNumber FROM question where question.exam_name=exam_name AND question.question_number=question_number;
  
  if numOfExams = 1 THEN
    if CHAR_LENGTH(answer) = 1 THEN
      if CHAR_LENGTH(question_contents) > 0 THEN
        if questionNumber = 0 THEN
          insert into question values( exam_name, question_number, answer, points, question_contents);
        end if;
      end if;
    end if;
  end if;
end//
