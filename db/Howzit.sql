CREATE TABLE Users (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(100) NOT NULL ,
    LastName VARCHAR(100) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    ProfilePicture VARCHAR(255) NULL,
    VerificationToken VARCHAR(255) NULL,
    IsVerified BOOLEAN DEFAULT FALSE
);

CREATE TABLE Posts (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    PostTimeStamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PostText TEXT NOT NULL,
    PostImage VARCHAR(255) NULL,
    UserId INT,
    FOREIGN KEY (UserId) REFERENCES Users(Id)
);

SELECT Posts.*, Users.FirstName, Users.LastName
FROM Posts
         JOIN Users ON Posts.UserId = Users.Id
ORDER BY Posts.Id DESC;

RENAME TABLE Users TO User;
RENAME TABLE Posts TO Post;


ALTER TABLE Users ADD UNIQUE (Email);

DROP TABLE Users;

