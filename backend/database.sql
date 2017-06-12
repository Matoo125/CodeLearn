CREATE TABLE topics(
	id int primary key auto_increment, -- eg. HTML, CSS, JavaScript
	title varchar(255) not null,
	description text default null,
	createdAt timestamp default current_timestamp,
	updatedAt timestamp default current_timestamp on update current_timestamp
);

-- every lesson has 3 parts: Theory, Exercise and Solution
CREATE TABLE lessons(
	id int primary key auto_increment,
	title varchar(255) not null, -- eg. Working with tables, Color theory
	brief text default null, -- short description of lesson
	theory text default null, -- theoretical content of the lesson
	exercise text default null, -- exercise for user to complete
	topic_id int not null, -- FK
	turn int(11) default 0,  -- if 0 lesson will be hidden, order number
	createdAt timestamp default current_timestamp,
	updatedAt timestamp default current_timestamp on update current_timestamp,
	CONSTRAINT FK_LessonOfTopic FOREIGN KEY (`topic_id`) REFERENCES topics(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE solutions(
	id int primary key auto_increment,
	lesson_id int(11) not null, -- FK
	solution text not null, -- pure solution code 
	explanation text default null, -- extra explanation
	priority int not null default 0, -- relevance of solution
	createdAt timestamp default current_timestamp,
	updatedAt timestamp default current_timestamp,
	CONSTRAINT FK_Solutions FOREIGN KEY (`lesson_id`) REFERENCES lessons(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE finishedLessons( -- solution should be accesible in users folder
	id int primary key auto_increment,
	user_id int not null,
	lesson_id int not null,
	createdAt timestamp default current_timestamp,
	updatedAt timestamp default current_timestamp on update current_timestamp,
	CONSTRAINT FK_finishedLessonsUser FOREIGN KEY (`user_id`) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_finishedLessonsLesson FOREIGN KEY (`lesson_id`) REFERENCES lessons(id) ON DELETE CASCADE ON UPDATE CASCADE
)