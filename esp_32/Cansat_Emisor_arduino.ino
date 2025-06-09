#include <SPI.h>
#include <nRF24L01.h>
#include <RF24.h>
#include <DHT.h>

// Pines
#define DHTPIN 2
#define DHTTYPE DHT11
#define LED_VERDE 3
#define LED_ROJO 4

// RF24
RF24 radio(9, 10); // CE, CSN
const byte direccion[6] = "00001";

// Sensor DHT
DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(9600);
  dht.begin();

  pinMode(LED_VERDE, OUTPUT);
  pinMode(LED_ROJO, OUTPUT);
  digitalWrite(LED_VERDE, LOW);
  digitalWrite(LED_ROJO, LOW);

  // Inicializar radio
  if (!radio.begin()) {
    Serial.println("Error al iniciar el módulo NRF24L01");
    digitalWrite(LED_ROJO, HIGH);
    while (true);
  }

  radio.openWritingPipe(direccion);
  radio.setPALevel(RF24_PA_LOW);
  radio.setDataRate(RF24_1MBPS);
  radio.stopListening();

  Serial.println("Emisor iniciado correctamente");
}

void loop() {
  float temp = dht.readTemperature();
  float hum = dht.readHumidity();

  if (isnan(temp) || isnan(hum)) {
    Serial.println("Error al leer DHT11");
    digitalWrite(LED_VERDE, LOW);
    digitalWrite(LED_ROJO, HIGH);
    delay(2000);
    return;
  }

  // Crear JSON
  String json = "{";
  json += "\"temp\":" + String(temp, 1) + ",";
  json += "\"hum\":" + String(hum, 1);
  json += "}";

  Serial.print("Enviando: ");
  Serial.println(json);

  // Convertir a array de char
  char jsonChar[64];
  json.toCharArray(jsonChar, sizeof(jsonChar));

  // Enviar
  bool enviado = radio.write(&jsonChar, sizeof(jsonChar));

  if (enviado) {
    Serial.println("Enviado correctamente");
    digitalWrite(LED_VERDE, HIGH);
    digitalWrite(LED_ROJO, LOW);
  } else {
    Serial.println("Error al enviar");
    digitalWrite(LED_VERDE, LOW);
    digitalWrite(LED_ROJO, HIGH);
  }

  delay(2000); // Frecuencia de envío
}
