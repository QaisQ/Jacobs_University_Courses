import processing.serial.*;
int lf = 10; // Linefeed in ASCII
String receivedString = null ;
Serial myPort ; // Serial port you are using
float [] acceleration = {0. , 0., 0.};
float pitch , roll ;
void setup ()
{
  size (640 , 360 , P3D);
  noStroke ();
  colorMode (RGB , 1);
  
  myPort = new Serial (this , "COM5", 9600);
  // Replace " COM1 " by your Arduino port .
  myPort.clear ();
}

void draw_rgb_cube ()
{
  background (0.4 , 0.4 , 0.4) ;
  scale (100) ;
  // Note the color convention : XYZ = RGB
  // Negative XYZ = light RGB
  beginShape ( QUADS );
  // Front (As +Z is coming out of the screen ) face : Red
  fill (0, 0, 1);
  vertex (-1, 1, 1);
  fill (0, 0, 1);
  vertex ( 1, 1, 1);
  fill (0, 0, 1);
  vertex ( 1, -1, 1);
  fill (0, 0, 1);
  vertex (-1, -1, 1);
  // Right face (As +X is on the right ): White
  fill (1, 0, 0);
  vertex ( 1, 1, 1);
  fill (1, 0, 0);
  vertex ( 1, 1, -1);
  fill (1, 0, 0);
  vertex ( 1, -1, -1);
  fill (1, 0, 0);
  vertex ( 1, -1, 1);
  // Back face (-Z): Light Blue
  fill (0.5 , 0.5 , 1);
  vertex ( 1, 1, -1);
  fill (0.5 , 0.5 , 1);
  vertex (-1, 1, -1);
  fill (0.5 , 0.5 , 1);
  vertex (-1, -1, -1);
  fill (0.5 , 0.5 , 1);
  vertex ( 1, -1, -1);
  // Left face (-X): Pink
  fill (1, 0.5 , 0.5) ;
  vertex (-1, 1, -1);
  fill (1, 0.5 , 0.5) ;
  vertex (-1, 1, 1);
  fill (1, 0.5 , 0.5) ;
  vertex (-1, -1, 1);
  fill (1, 0.5 , 0.5) ;
  vertex (-1, -1, -1);
  // Bottom face (+Y is pointing down the screen ): Green
  fill (0, 1, 0);
  vertex (-1, 1, -1);
  fill (0, 1, 0);
  vertex ( 1, 1, -1);
  fill (0, 1, 0);
  vertex ( 1, 1, 1);
  fill (0, 1, 0);
  vertex (-1, 1, 1);
  // Top face (-Y): Light Green
  fill (0.5 , 1, 0.5) ;
  vertex (-1, -1, -1);
  fill (0.5 , 1, 0.5) ;
  vertex ( 1, -1, -1);
  fill (0.5 , 1, 0.5) ;
  vertex ( 1, -1, 1);
  fill (0.5 , 1, 0.5) ;
  vertex (-1, -1, 1);
  endShape ();
}
void draw ()
{
  while (myPort.available () > 0)
    {
      receivedString = myPort.readStringUntil(lf);
       if ( receivedString != null )
       {
          boolean newSample = parseStringForAccelerations ( receivedString );
          if ( newSample )
            {
              print ("Got acceleration : ");
              print ( acceleration [0]) ;
              print (", ");
              print ( acceleration [1]) ;
              print (", ");
              print ( acceleration [2]) ;
              println (".");
                // Compute the roll and pitch angles
              float acc_norm = sqrt((acceleration [0])*(acceleration [0]) + (acceleration [1])*(acceleration [1]) + (acceleration [2])*(acceleration [2])); // fill -in
              float ax= acceleration [0]/ acc_norm ;
              float ay= acceleration [1]/ acc_norm ;
              float az= acceleration [2]/ acc_norm ;
              
              
              // Fill -in: Compute roll and pitch
              pitch = acc_norm*sin(az/acc_norm);
              roll = acc_norm*tan(ax/cos(pitch));
             
              
               // Draw the rotated object here .
              translate ( width /2.0 , height /2.0 , -50);
              // Fill -in: rotate by roll and pitch
              rotateX(pitch);
              rotateY(roll);
              draw_rgb_cube ();
            }
      }
}
  myPort.clear ();
}
  boolean parseStringForAccelerations ( String str) {
  boolean sampleComplete = false ;
  String [] substrings = str. split (" ");
  if ( substrings [0]. equals ("X:"))
  {
    acceleration [0]= float ( substrings [1]) ;
  }
  else if ( substrings [0]. equals ("Y:"))
  {
    acceleration [1]= float ( substrings [1]) ;
  }
  else if ( substrings [0]. equals ("Z:"))
  {
    acceleration [2]= float ( substrings [1]) ;
    sampleComplete = true ;
  }
  else
  {
    print (" Status message : ");
    println ( receivedString ); // Prints status messages
  }
  return sampleComplete ;
}
