size(920, 680); // open a window with the specified dimensions (width, length)
background(150, 10, 10); // set background color to dark red

smooth(); // makes the lines smooth
strokeWeight(6); // sets the width of the lines drawn
strokeJoin(ROUND); // sets the style of the joints which connect line segments

//Body
rect(200,200,400,150); //Car body
rect(550, 250,50,40); //Front windshield

//Tire 1
ellipse(300,350,80,80); //Creates thick outer circle (strokeWeight still 6)
strokeWeight(2);
ellipse(300,350,60,60); //Creates thinner inner circle

//Tire 2

strokeWeight(6);
ellipse(500,350,80,80);//Creates thick outer circle
strokeWeight(2);
ellipse(500,350,60,60);//Creates thinner inner circle
