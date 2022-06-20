float x = 60;
float y = 60;
int diameter = 60;
void setup () 
{
  size (480 , 360) ;
  frameRate (30) ;
  background (102) ;

}

void draw ()
{
  x = x+2.8;
  y = y+2.2;
  ellipse (x, y, diameter , diameter );
}
