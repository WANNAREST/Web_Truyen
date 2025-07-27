CREATE DATABASE Final_Project_2024_2;

create type enum_like as enum('like', 'dislike')

-- Table Admin
CREATE TABLE Admin (
    admin_id INT generated always as identity PRIMARY KEY,
    admin_username VARCHAR(255) NOT NULL,
    admin_password VARCHAR(255) NOT NULL,
    verify_admin_password VARCHAR(255) NOT NULL,
    verify_admin_code VARCHAR(10) NOT NULL,
    admin_email VARCHAR(255) NOT NULL
);

-- Table Truyen
CREATE TABLE Truyen (
    id INT generated always as identity PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    genres VARCHAR(255) NOT NULL,
    chapter INT NOT NULL,
    rating FLOAT NOT NULL,
    state VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(255) NOT NULL
);

-- Table Chapter
CREATE TABLE Chapter (
    id INT generated always as identity PRIMARY KEY,
    story_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATE NOT NULL,
    updated_at DATE NOT NULL,
    CONSTRAINT FK_ChaptertoTruyen FOREIGN KEY (story_id) REFERENCES Truyen(id)
);

-- Table Users
CREATE TABLE dang_ky (
    id INT generated always as identity PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    verify_password VARCHAR(255) NOT NULL
);

-- Table Comment
CREATE TABLE user_comment (
    comment_id INT generated always as identity PRIMARY KEY,
    user_id INT NOT NULL,
    story_id INT NOT NULL,
    chapter_id int not null,
	parent_id int,
    comment TEXT,
    likeCount INT DEFAULT 0,
    dislikeCount INT DEFAULT 0,
    date_time_post TIMESTAMP NOT NULL,
    CONSTRAINT FK_CommenttoUsers FOREIGN KEY (user_id) REFERENCES dang_ky(id),
    CONSTRAINT FK_CommenttoTruyen FOREIGN KEY (story_id) REFERENCES Truyen(id),
    constraint FK_CommenttoChapter foreign key (chapter_id) references Chapter(id) 
);

-- Table Read (User đọc Truyen + Favorite flag)
CREATE TABLE fav_book (
    user_id INT NOT NULL,
    truyen_id INT NOT NULL,
    CONSTRAINT FK_FavBooktoUsers FOREIGN KEY (user_id) REFERENCES dang_ky(id),
    CONSTRAINT FK_FavBooktoTruyen FOREIGN KEY (truyen_id) REFERENCES Truyen(id),
    CONSTRAINT PK_FavBook PRIMARY KEY (user_id, truyen_id)
);

-- Table User_comment_like (User phản ứng Comment)
CREATE TABLE user_comment_like (
    user_id INT NOT NULL,
    comment_id INT NOT NULL,
    type ENUM_like NOT NULL,
    CONSTRAINT FK_CommentLikeToUsers FOREIGN KEY (user_id) REFERENCES dang_ky(id),
    CONSTRAINT FK_CommentLikeToComment FOREIGN KEY (comment_id) REFERENCES user_Comment(comment_id),
    CONSTRAINT UK_UserComment UNIQUE (user_id, comment_id) -- User chỉ phản ứng 1 lần / comment
);

-- Table Admin quản lý Users (n-n)
CREATE TABLE admin_user (
    admin_id INT NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (admin_id, user_id),
    FOREIGN KEY (admin_id) REFERENCES Admin(admin_id),
    FOREIGN KEY (user_id) REFERENCES dang_ky(id)
);

-- Admin quản lý Truyen
CREATE TABLE admin_truyen (
    admin_id INT NOT NULL,
    truyen_id INT NOT NULL,
    PRIMARY KEY (admin_id, truyen_id),
    FOREIGN KEY (admin_id) REFERENCES Admin(admin_id),
    FOREIGN KEY (truyen_id) REFERENCES Truyen(id)
);

drop type enum_like

drop table admin_truyen
drop table admin_user
drop table user_comment_like
drop table fav_book
drop table chapter
drop table admin
drop table truyen
drop table user_comment
drop table dang_ky

drop database final_project_2024_2

--Câu truy vấn
SELECT id, name, genres, chapter, rating, state, image FROM truyen ORDER BY id DESC

--Lấy truyện hot
SELECT id, name, genres, chapter, rating, state, image 
FROM truyen 
WHERE rating >= 8 
ORDER BY rating DESC, id DESC LIMIT 10






