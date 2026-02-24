CREATE DATABASE IF NOT EXISTS LGU;
CREATE USER IF NOT EXISTS 'lgu_admin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'YsqnXk6q#145';
ALTER USER 'lgu_admin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'YsqnXk6q#145';
GRANT ALL PRIVILEGES ON LGU.* TO 'lgu_admin'@'localhost';
FLUSH PRIVILEGES;
