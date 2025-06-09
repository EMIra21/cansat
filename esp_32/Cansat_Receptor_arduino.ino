#include <SPI.h>
#include <nRF24L01.h>
#include <RF24.h>

// Pines RF24
RF24 radio(10, 9); // CE, CSN
const byte direccion[6] = "00001";

// Buffer para recibir datos
char datos[64];
String buffer = "";

void setup() {
  Serial.begin(9600);

  if (!radio.begin()) {
    Serial.println("Error al iniciar NRF24L01");
    while (true); // Detener si no se inicia el radio
  }

  radio.openReadingPipe(0, direccion);
  radio.setPALevel(RF24_PA_LOW);
  radio.setDataRate(RF24_1MBPS);
  radio.startListening();

  Serial.println("Receptor NRF24L01 iniciado");
}

void loop() {
  if (radio.available()) {
    radio.read(&datos, sizeof(datos));
    String recibido = String(datos);
    buffer += recibido;

    // Validación JSON simple
    if (buffer.startsWith("{") && buffer.endsWith("}")) {
      Serial.println("JSON recibido:");
      Serial.println(buffer);
      buffer = "";
    } else if (buffer.length() > 128) {
      buffer = ""; // Evitar desbordamiento
    }
  }

  delay(10);
}
