-- #######
-- ## Question table
-- #######
CREATE TABLE IF NOT EXISTS `Question` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT ,
  `body` VARCHAR(45) NOT NULL
);


-- #######
-- ## Answer table
-- #######
CREATE TABLE IF NOT EXISTS Comment (
  id INTEGER PRIMARY KEY AUTOINCREMENT ,
  question_id INTEGER NOT NULL,
  body VARCHAR(45) NOT NULL
);

-- #######
-- ##  Vote table
-- #######
CREATE TABLE IF NOT EXISTS Vote (
	id INTEGER PRIMARY KEY NOT NULL,
	question_id INTEGER NOT NULL,
	ip VARCHAR(255) NOT NULL,
	creation_date DATETIME NOT NULL
);