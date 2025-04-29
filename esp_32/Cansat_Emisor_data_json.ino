#include <Wire.h>
#include <SPI.h>
#include <LoRa.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME680.h>
#include <MPU6050.h>

// Pines LoRa
#define LORA_SS 5
#define LORA_RST 14
#define LORA_DIO0 26

// Pines MICS
#define MICS_PIN 34

// Instancias
Adafruit_BME680 bme;
MPU6050 mpu;

void setup() {
  Serial.begin(9600);
  while (!Serial);

  // Inicializar LoRa
  LoRa.setPins(LORA_SS, LORA_RST, LORA_DIO0);
  if (!LoRa.begin(433E6)) {
    Serial.println("Error al iniciar LoRa");
    while (true);
  }
  Serial.println("LoRa iniciado correctamente");

  // Inicializar BME680
  if (!bme.begin()) {
    Serial.println("No se detectó el BME680");
    while (true);
  }
  bme.setTemperatureOversampling(BME680_OS_8X);
  bme.setHumidityOversampling(BME680_OS_2X);
  bme.setPressureOversampling(BME680_OS_4X);
  bme.setGasHeater(320, 150); // 320°C por 150 ms

  // Inicializar MPU6050
  Wire.begin(21, 22);
  mpu.initialize();
  if (!mpu.testConnection()) {
    Serial.println("MPU6050 no conectado");
    while (true);
  }

  // Pin del sensor MICS
  pinMode(MICS_PIN, INPUT);
}

void loop() {
  // Lectura de BME680
  if (!bme.performReading()) {
    Serial.println("⚠ Error al leer BME680");
    delay(2000);
    return;
  }

  float temp = bme.temperature;
  float hum = bme.humidity;
  float pres = bme.pressure / 100.0;
  float gas = bme.gas_resistance / 1000.0;

  // Lectura del sensor MICS
  int micsRaw = analogRead(MICS_PIN);

  float CO = map(micsRaw, 0, 4095, 1, 10000);
  float H2 = map(micsRaw, 0, 4095, 1, 10000);
  float CH4 = map(micsRaw, 0, 4095, 10000, 20000);
  float NH3 = map(micsRaw, 0, 4095, 1, 500);
  float EtOH = map(micsRaw, 0, 4095, 10, 500);

  // Lectura del MPU6050
  int16_t ax, ay, az, gx, gy, gz;
  mpu.getMotion6(&ax, &ay, &az, &gx, &gy, &gz);

  // Crear JSON
  String json = "{";
  json += "\"T\":" + String(temp, 1) + ",";
  json += "\"H\":" + String(hum, 1) + ",";
  json += "\"P\":" + String(pres, 1) + ",";
  json += "\"G\":" + String(gas, 1) + ",";
  json += "\"CO\":" + String(CO) + ",";
  json += "\"H2\":" + String(H2) + ",";
  json += "\"CH4\":" + String(CH4) + ",";
  json += "\"NH3\":" + String(NH3) + ",";
  json += "\"EtOH\":" + String(EtOH) + ",";
  json += "\"AX\":" + String(ax) + ",";
  json += "\"AY\":" + String(ay) + ",";
  json += "\"AZ\":" + String(az) + ",";
  json += "\"GX\":" + String(gx) + ",";
  json += "\"GY\":" + String(gy) + ",";
  json += "\"GZ\":" + String(gz);
  json += "}";

  // Enviar por LoRa
  LoRa.beginPacket();
  LoRa.print(json.c_str()); // Enviar como C string
  LoRa.endPacket();

  Serial.println("JSON enviado:");
  Serial.println(json);
}