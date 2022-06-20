
int input_pin = A0;
int LED = 10;
int sensor_sample = 0;

void setup (){
Serial . begin (9600) ;
pinMode (LED , OUTPUT );
}
void loop ()
{
sensor_sample = analogRead (input_pin);
Serial.print("sensor value = ");
Serial.println(sensor_sample);
if ( sensor_sample < 70 )
{
digitalWrite (LED , HIGH );
} else {
digitalWrite (LED , LOW );
}
delay (50) ;
}
