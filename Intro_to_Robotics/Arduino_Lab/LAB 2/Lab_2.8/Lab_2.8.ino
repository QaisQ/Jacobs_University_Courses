#include <Servo.h>
Servo s; // create servo object ;
int angle = 0;
void setup ()
{
s.attach (8); // control signal on pin 8
}
void loop ()
{

for(angle = 0; angle < 180; angle++)  // Goes from 0 degrees to 180 degrees
{
 s.write(angle);                      // Tell the Servo to go to position in variable 'angle'
 delay(16);                           // Waits 16ms for the Servo to reach the position 
}
for(angle = 180; angle > 0; angle--)
{
 s.write(angle);
 delay(16);
}

delay(6000);
}
