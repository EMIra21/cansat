CREATE TABLE sensor_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    temperatura FLOAT,
    humedad FLOAT,
    presion FLOAT,
    gas FLOAT,
    co FLOAT,
    h2 FLOAT,
    ch4 FLOAT,
    nh3 FLOAT,
    etoh FLOAT,
    ax FLOAT,
    ay FLOAT,
    az FLOAT,
    gx FLOAT,
    gy FLOAT,
    gz FLOAT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);