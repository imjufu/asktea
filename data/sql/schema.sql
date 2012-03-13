-- #######
-- ## Question table
-- #######
DROP TABLE Question;

CREATE TABLE IF NOT EXISTS Question (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  creation_date DATETIME NOT NULL
);


-- #######
-- ## Answer table
-- #######
DROP TABLE Comment;

CREATE TABLE IF NOT EXISTS Comment (
  id INTEGER PRIMARY KEY AUTOINCREMENT ,
  question_id INTEGER NOT NULL,
  body TEXT NOT NULL,
  creation_date DATETIME NOT NULL
);

-- #######
-- ##  Vote table
-- #######
DROP TABLE Vote;

CREATE TABLE IF NOT EXISTS Vote (
	id INTEGER PRIMARY KEY NOT NULL,
	question_id INTEGER NOT NULL,
	ip VARCHAR(255) NOT NULL,
	creation_date DATETIME NOT NULL
);