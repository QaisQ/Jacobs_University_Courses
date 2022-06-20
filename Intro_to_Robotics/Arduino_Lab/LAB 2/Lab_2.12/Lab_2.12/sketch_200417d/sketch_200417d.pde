import processing.serial.*;

Serial port; // Create object from Serial class
int val; // Data received from the serial port
void setup () 
{
  size (200 , 200) ;
// Open the port that the board is connected to and use the same speed (9600 bps)

  port = new Serial (this , "COM5", 9600) ;
}
void draw ()
{
// draw a gradient from black to white
  for (int i = 0; i < 256; i++)
  {
    stroke (i);
    line (i, 0, i, 150) ;
  }
// write the current X- position of the mouse to the serial port as
// a single byte
port.write(mouseX);
}
