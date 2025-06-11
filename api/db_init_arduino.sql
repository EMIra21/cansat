CREATE TABLE sensor_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    temperatura FLOAT,
    humedad FLOAT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);