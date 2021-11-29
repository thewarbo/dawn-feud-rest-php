USE questions;

CREATE TABLE questions(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    asked VARCHAR(100)
);

CREATE TABLE responses (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    answered VARCHAR(30),
    respondents INT NOT NULL,
    question_id INT,
    FOREIGN KEY (question_id) REFERENCES questions(id)
);