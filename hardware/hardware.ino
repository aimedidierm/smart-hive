// #include <DHT.h>
#include <Wire.h>
// #include <TinyGsmClient.h>
#include <SoftwareSerial.h>
#include <HX711.h>

#define DHTPIN 2     // DHT11 sensor pin
#define DHTTYPE DHT11
#define BUZZER_PIN 8 // Buzzer pin
#define LOAD_CELL_DOUT_PIN 3
#define LOAD_CELL_SCK_PIN 4

// DHT dht(DHTPIN, DHTTYPE);
HX711 scale;
// SoftwareSerial gsmSerial(7, 6); // RX, TX for GSM module
// TinyGsm modem(gsmSerial);
// TinyGsmClient client(modem);

const char apn[]  = "your_apn";  // Set your APN
const char user[] = "";          // APN user
const char pass[] = "";          // APN password
const char server[] = "your_https_server.com"; // Your HTTPS server
const int  port = 443;           // HTTPS port

void setup() {
  Serial.begin(9600);
  // gsmSerial.begin(9600);
  
  // dht.begin();
  scale.begin(LOAD_CELL_DOUT_PIN, LOAD_CELL_SCK_PIN);
  
  pinMode(BUZZER_PIN, OUTPUT);
  digitalWrite(BUZZER_PIN, LOW); // Turn off buzzer initially
  
  // Serial.println("Initializing modem...");
  // modem.restart();
  
  // Serial.println("Connecting to network...");
  // modem.gprsConnect(apn, user, pass);
  
  // if (modem.isNetworkConnected()) {
  //   Serial.println("Connected to the internet.");
  // } else {
  //   Serial.println("Failed to connect to network.");
  //   while (true); // Stop execution
  // }
}

void loop() {
  // Reading data from DHT11
  // float humidity = dht.readHumidity();
  // float temperature = dht.readTemperature();

  // Reading data from Load Cell
  float weight = scale.get_units(5); // Average of 5 readings
  
  // Trigger buzzer if weight exceeds a threshold (e.g., 1000g)
  if (weight > 1000) {
    digitalWrite(BUZZER_PIN, HIGH); // Turn on buzzer
  } else {
    digitalWrite(BUZZER_PIN, LOW);  // Turn off buzzer
  }

  // Print data to Serial
  Serial.print("Temp: ");
  // Serial.print(temperature);
  Serial.print("C, Humidity: ");
  // Serial.print(humidity);
  Serial.print("%, Weight: ");
  Serial.print(weight);
  Serial.println("g");

  // Sending data to the server
  // if (client.connect(server, port)) {
  //   String postData = "temp=" + String(temperature) + "&humidity=" + String(humidity) + "&weight=" + String(weight);
    
  //   client.println("POST /your-endpoint HTTP/1.1");
  //   client.println("Host: " + String(server));
  //   client.println("Connection: close");
  //   client.println("Content-Type: application/x-www-form-urlencoded");
  //   client.println("Content-Length: " + String(postData.length()));
  //   client.println();
  //   client.println(postData);
    
  //   while (client.connected()) {
  //     String line = client.readStringUntil('\n');
  //     if (line == "\r") {
  //       break;
  //     }
  //   }
  //   client.stop();
  //   Serial.println("Data sent successfully.");
  // } else {
  //   Serial.println("Failed to connect to the server.");
  // }

  delay(5000); // Wait for 5 seconds before next data collection
}
