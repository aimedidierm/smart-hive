#include "HX711.h"
#include "DHT.h"
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

// Buzzer
const int buzzerPin = D5;  // GPIO14

// DHT11 Sensor
#define DHTPIN D4         // GPIO2
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

// Load Cell (HX711)
const int LOADCELL_DOUT_PIN = D2;  // GPIO4
const int LOADCELL_SCK_PIN = D1;   // GPIO5
HX711 scale;

// Wi-Fi Credentials
const char* ssid = "Bees";
const char* password = "123456789s";

// Server URL
const char* serverName = "http://192.168.43.203:8000/api/hardware";

void setup() {
  Serial.begin(115200);

  // Initialize Buzzer
  pinMode(buzzerPin, OUTPUT);

  // Initialize DHT Sensor
  dht.begin();

  // Initialize Load Cell
  scale.begin(LOADCELL_DOUT_PIN, LOADCELL_SCK_PIN);

  // Connect to Wi-Fi
  connectToWiFi();
}

void loop() {
  // 1. Buzzer Provides Sound for Bees Attraction
  // activateBuzzer();

  // 2. Measure Humidity and Temperature
  float humidity = dht.readHumidity();
  float temperature = dht.readTemperature();

  if (isnan(humidity) || isnan(temperature)) {
    Serial.println("Failed to read from DHT sensor!");
  } else {
    Serial.print("Humidity: ");
    Serial.print(humidity);
    Serial.print(" %\t");
    Serial.print("Temperature: ");
    Serial.print(temperature);
    Serial.println(" *C");
  }

  // 3. Measure Weight (Load Cell)
  if (scale.is_ready()) {
    long weight = scale.read();
    Serial.print("Weight: ");
    Serial.println(weight);
  } else {
    Serial.println("HX711 not found.");
  }

  // 4. Send Data to Website
  sendDataToWebsite(humidity, temperature, scale.read());

  delay(1000);  // Wait for 1 minute before next cycle
}

// Function to connect to Wi-Fi
void connectToWiFi() {
  Serial.println("Connecting to Wi-Fi...");
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting...");
  }

  Serial.println("Connected to Wi-Fi");
}

// Function to activate the buzzer
void activateBuzzer() {
  digitalWrite(buzzerPin, HIGH);  // Turn on the buzzer
  delay(500);                     // Sound for 0.5 seconds
  digitalWrite(buzzerPin, LOW);   // Turn off the buzzer
  delay(500);                     // Pause for 0.5 seconds
}

// Function to send data to the website
void sendDataToWebsite(float humidity, float temperature, long weight) {
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;  // Create WiFiClient object
    HTTPClient http;

    http.begin(client, serverName);  // Pass the WiFiClient object and the URL
    http.addHeader("Content-Type", "application/json");

    // Create JSON payload
    String jsonPayload = "{\"humidity\": " + String(humidity) + 
                         ", \"temperature\": " + String(temperature) + 
                         ", \"weight\": " + String(weight) + "}";

    int httpResponseCode = http.POST(jsonPayload);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println(httpResponseCode);
      Serial.println(response);
    } else {
      Serial.print("Error on sending POST: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("Error: Not connected to Wi-Fi.");
  }
}