float rotx , roty ;
void setup () 
{
  size (400 ,400 , P3D);
  rotx = 0.0;
  roty = 0.0;
}
void draw ()
{
  background (255) ;
  pushMatrix ();
  translate ( width /2.0 , height /2.0 , -50);
  rotateX ( rotx );
  rotateY ( roty );
  draw_axes ();
  popMatrix ();
}
void draw_axes ()
{
  fill (100 , 200 , 100 , 127) ;
  stroke (0);
  box (90 , 60, 30) ;
  stroke (255 , 0, 0);
  line (0, 0, 0, 100 , 0, 0); // Red X- Axis
  stroke (0, 255 , 0);
  line (0, 0, 0, 0, 100 , 0); // Green Y- Axis
  stroke (0, 0, 255) ;
  line (0, 0, 0, 0, 0, 100) ; // Blue Z- Axis
}
/** This is an event - handler function .
*/
void mouseDragged ()
{
  float rate = 0.01;
  rotx += (  pmouseY - mouseY ) * rate ;
  roty += ( mouseX - pmouseX ) * rate ;
}
