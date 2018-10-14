#include <ESP8266WiFi.h>
//#include <DNSServer.h>
//#include <ESP8266WebServer.h>
//#include <WiFiManager.h>
#include <IRCClient.h>

#include <ESP8266HTTPClient.h>

#define IRC_SERVER   "irc.example.com"
#define IRC_PORT     6667
#define IRC_NICKNAME "nick"
#define IRC_USER     "user"
#define REPLY_TO     "owner"

// PHP TARGET
String HOST = "http://192.168.0.43/irclog.php";

//WiFiManager wm;
WiFiClient wificlient;
// HTTPClient http;
IRCClient irc(IRC_SERVER, IRC_PORT, wificlient);

void setup() {
  Serial.begin(115200);
  WiFi.printDiag(Serial);
//  wm.autoConnect("ESP_AP");

  WiFi.mode(WIFI_STA);
  WiFi.disconnect();
  WiFi.begin("WIFI","PASSWD");
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  Serial.println("WiFi Connected!");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());

  irc.setCallback(callback);
  irc.setSentCallback(debugSentCallback);
}

void loop() {
  if (!irc.connected()) {
    Serial.println("Attempting IRC connection...");
    if (irc.connect(IRC_NICKNAME, IRC_USER)) {
      Serial.println("connected");
    } else {
      Serial.println("failed... try again in 5 seconds");
      delay(5000);
    }
    return;
  }
  irc.loop();

}

void callback(IRCMessage ircMessage) {
  String cmd("<COMMAND> " + ircMessage.command);
  Serial.println(cmd);
  if (ircMessage.command == "PRIVMSG" && ircMessage.text[0] != '\001') {
    String message("<" + ircMessage.nick + "> " + ircMessage.text);
    String tmp = String(millis());
    message = tmp + " # " + message;
    Serial.println(message);
    
    record(ircMessage.nick, ircMessage.user, ircMessage.text);

    if (ircMessage.nick == REPLY_TO) {
      irc.sendMessage(ircMessage.nick, "Bot runtime: " + tmp);
    }

    return;
  }
  Serial.println(ircMessage.original);
}

void debugSentCallback(String data) {
  Serial.println(data);
}

void record(String fromuser, String touser, String msg){
  HTTPClient http;
  String URL = HOST + "?id=1" + "&fromuser=" + fromuser + "&touser=" + touser + "&msg=" + msg;
  http.begin(URL);
  int httpCode = http.GET();
  String response = http.getString();
  http.end(); 
}

