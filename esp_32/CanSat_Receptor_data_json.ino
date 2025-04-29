#include <SPI.h>
#include <LoRa.h>

// Pines LoRa
#define LORA_SS 5
#define LORA_RST 14
#define LORA_DIO0 26

void setup() {
  Serial.begin(9600);
  while (!Serial);

  // Inicializar LoRa
  LoRa.setPins(LORA_SS, LORA_RST, LORA_DIO0);
  if (!LoRa.begin(433E6)) {
    Serial.println("Error al iniciar LoRa");
    while (true);
  }
  Serial.println("Receptor LoRa iniciado");
}

void loop() {
  static String buffer = "";
  int packetSize = LoRa.parsePacket();
  
  if (packetSize) {
    while (LoRa.available()) {
      char c = (char)LoRa.read();
      buffer += c;
    }
    
    // Verificar si el buffer contiene un JSON completo
    if (buffer.startsWith("{") && buffer.endsWith("}")) {
      Serial.println(buffer); // Imprime el JSON completo
      buffer = ""; // Limpia el buffer después de imprimir
    } else if (buffer.length() > 500) { // Evitar desbordamiento de buffer
      buffer = "";
    }
  }
  
  delay(10); // Pequeña pausa para estabilidad
}
