CREATE USER IF NOT EXISTS 'lgu_admin'@'127.0.0.1' IDENTIFIED WITH mysql_native_password BY 'YsqnXk6q#145';
ALTER USER 'lgu_admin'@'127.0.0.1' IDENTIFIED WITH mysql_native_password BY 'YsqnXk6q#145';
GRANT ALL PRIVILEGES ON LGU.* TO 'lgu_admin'@'127.0.0.1';
FLUSH PRIVILEGES;
