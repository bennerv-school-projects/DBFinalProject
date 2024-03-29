# Set the delimiter
delimiter //

DROP PROCEDURE IF EXISTS create_exam;
DROP PROCEDURE IF EXISTS create_question;
DROP PROCEDURE IF EXISTS create_choice;


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
  in answer char(1),
  in points integer,
  in question_contents varchar(256)
)

BEGIN
  declare numOfExams integer;
  declare questionNumber integer;
  
  select COUNT(*) into numOfExams FROM exam where exam.exam_name=exam_name;
  select (1 + COUNT(question_number)) into questionNumber FROM question where question.exam_name=exam_name;
  
  if numOfExams = 1 THEN
    if CHAR_LENGTH(answer) = 1 THEN
      if CHAR_LENGTH(question_contents) > 0 THEN
        insert into question values( exam_name, questionNumber, answer, points, question_contents);
      end if;
    end if;
  end if;
end//

# Create a procedure for the choice table to create a choice for an exam question
CREATE PROCEDURE create_choice(
  in id char(1),
  in exam_name varchar(50),
  in question_number integer,
  in choice_contents varchar(256)
)

BEGIN
  declare numberOfExams integer;
  declare questionNumber integer;
  declare idNumber integer;
  
  select COUNT(*) into numberOfExams FROM exam WHERE exam.exam_name=exam_name;
  select COUNT(*) into questionNumber FROM question WHERE question.exam_name=exam_name AND question.question_number=question_number;
  
  if numberOfExams = 1 THEN
    if questionNumber = 1 THEN 
      if CHAR_LENGTH(choice_contents) > 0 THEN
        if CHAR_LENGTH(id) > 0 THEN
          insert into choice values(id, exam_name, question_number, choice_contents);
        end if;
      end if;
    end if;
  end if;
end//
