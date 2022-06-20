void setup ()
{
  size(480, 360) ;
  smooth ();
  noStroke ();
  fill(102) ;
}

void draw ()
{
  background(255, 0, 0);
  ellipse(mouseX , mouseY , 9, 9);
}
