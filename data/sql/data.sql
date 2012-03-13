-- #######
-- ## Questions
-- #######
DELETE FROM Question;

INSERT INTO "Question" VALUES(1,'Est-ce une blague ?','Est-ce que vous pensez réussir ?','2012-03-13');
INSERT INTO "Question" VALUES(2,'Comment acheter','Je veux acheter chez vous','2012-03-13');
INSERT INTO "Question" VALUES(3,'Est-ce que tout sera open source ?','Est-ce que tout sera open-source ?','2012-03-13');

-- #######
-- ## Comments
-- #######
DELETE Comment;

INSERT INTO "Comment" VALUES(1,1,'Commentaire 1','2012-03-13');
INSERT INTO "Comment" VALUES(2,1,'Commentaire 2','2012-03-13');
INSERT INTO "Comment" VALUES(3,2,'commentaire 3','2012-03-13');

-- #######
-- ## Votes
-- #######
DELETE Vote;

INSERT INTO "Vote" VALUES(1,1,'192.168.1.20','2012-03-13');
INSERT INTO "Vote" VALUES(2,1,'192.168.1.21','2012-03-13');
INSERT INTO "Vote" VALUES(3,2,'192.168.1.20','2012-03-13');
