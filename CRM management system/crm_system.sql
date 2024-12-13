/*Create database*/

CREATE DATABASE crm_system;

/*Create Users table*/

CREATE TABLE users (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(100) NOT null,
    email varchar(100) UNIQUE NOT null,
    password varchar(255) UNIQUE NOT null,
    role ENUM('admin','user') DEFAULT 'admin' ,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*Create Contacts table*/

CREATE TABLE contacts (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(100) NOT null,
    email varchar(100) UNIQUE NOT null,
    phone varchar(15),
    address TEXT,
    user_id int NOT null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

/* create task table */

CREATE TABLE tasks (
    id int AUTO_INCREMENT PRIMARY KEY,
    title varchar(255) NOT null,
    description TEXT,
    due_date DATE NOT null,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    user_id int NOT null,
    contact_id int DEFAULT null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE SET null
);

/* create notes table  */

CREATE TABLE notes (
    id int AUTO_INCREMENT PRIMARY KEY,
    note TEXT NOT null,
    user_id int NOT null,
    contact_id int DEFAULT null,
    task_id int DEFAULT null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE CASCADE,
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE
);

/* create table interactions */

CREATE TABLE interactions (
    id int AUTO_INCREMENT PRIMARY KEY,
    contact_id int,
    user_id int,
    interaction_type ENUM('Call', 'Meeting', 'Email', 'Message', 'Other') NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    notes TEXT,
    follow_up_date DATE,
    status ENUM('Completed', 'Pending', 'Canceled') DEFAULT 'Pending',
    FOREIGN KEY (contact_id) REFERENCES contacts(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);