x = linspace(-2*pi,2*pi,100);
y = sin(x);
plot(x,y)
grid
hold on
y1 = mysin(x);
plot(x,y1,'r:')
axis( [-2*pi,2*pi,-2,2] )