void setup ()
{
size (480 , 120) ;
}

void draw ()
{
if ( mousePressed )
{
  fill (0);
  if ( mouseButton == LEFT )
    println (" Left mouse pressed .");
  else
    println (" Right mouse pressed .");
}
else
{
  fill (255) ;
}
ellipse (mouseX , mouseY , 80, 80);
}
