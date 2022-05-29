CREATE TABLE application6 (
	    id INT(10) unsigned NOT NULL AUTO_INCREMENT,
	    name VARCHAR(128) NOT NULL DEFAULT '',
	    email VARCHAR(30),
	    date DATETIME(4),
	    sex VARCHAR(10),
	    limb INT(5),
	    bio TEXT,
	    PRIMARY KEY(id)
	    );
CREATE TABLE users6(
	    id INT(10) unsigned NOT NULL AUTO_INCREMENT,
	    login VARCHAR(128),
	    pass VARCHAR(255),
	    PRIMARY KEY(id)
	    );
	

CREATE TABLE supers6(
	    id INT(10) unsigned NOT NULL,
	    superpowers INT(10)
	    );
	   
CREATE TABLE SuperDef(
	    id INT(10) unsigned NOT NULL,
	    name VARCHAR(128)
	    );
	    
INSERT INTO SuperDef  VALUES 
        ('1','Левитация'),
        ('2','Прохождение сквозь стены'),
        ('3','Высыпаться за 2 часа'),
        ('4','Бессмертие');
