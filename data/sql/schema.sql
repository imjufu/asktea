-- #######
-- ## Question table
-- #######
DROP TABLE IF EXISTS Question;

CREATE TABLE IF NOT EXISTS Question (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  author VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  creation_date DATETIME NOT NULL
);


-- #######
-- ## Answer table
-- #######
DROP TABLE IF EXISTS Comment;

CREATE TABLE IF NOT EXISTS Comment (
  id INTEGER PRIMARY KEY AUTOINCREMENT ,
  question_id INTEGER NOT NULL,
  author VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  creation_date DATETIME NOT NULL
);

-- #######
-- ##  Vote table
-- #######
DROP TABLE IF EXISTS Vote;

CREATE TABLE IF NOT EXISTS Vote (
	id INTEGER PRIMARY KEY NOT NULL,
	question_id INTEGER NOT NULL,
	ip VARCHAR(255) NOT NULL,
	creation_date DATETIME NOT NULL
);

-- #######
-- ##  Admin table
-- #######
DROP TABLE IF EXISTS Admin;

CREATE TABLE IF NOT EXISTS Admin (
  id INTEGER PRIMARY KEY NOT NULL,
  login VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL
);