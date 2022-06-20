clc, close all, clear all
%%Set axis and figures

myaxes = axes();
view(3);
grid on;
axis equal;
myaxes.XLim = [-2 2];
myaxes.YLim = [-2 10];
myaxes.ZLim = [-1.5 1.5];
hold on
xlabel('x')
ylabel('y')
zlabel('z')

%%Gernerating a cylinder, cone and a sphere
[xcylinder, ycylinder, zcylinder] = cylinder([0.2 0.2]);
[xcone, ycone, zcone] = cylinder([0.1 0.0]);
[xsphere, ysphere, zsphere] = sphere();

%%Plot different orientations of these shapes
%assign all surfaces to a variable 'h'
h(1) = surface(xcylinder, ycylinder, zcylinder);
h(2) = surface(ycylinder, zcylinder,xcylinder);
h(3) = surface(zcylinder,xcylinder, ycylinder, 'FaceColor', 'red');
%h(4) = surface(-zcylinder,xcylinder+2, ycylinder);

%h(5) = surface(-zcone, -0.5*xcone, ycylinder+0.5);

%%Create a group object and parent surfaces  
combinedObject = hgtransform('parent', myaxes);
set(h, 'parent', combinedObject);
drawnow

%%Define the motion coordinates
longitude = 0:10; %x-direction translation
latitude = [0 1 1 1 0 0 -1 -1 -1 -1]; %y-direction translation
altitude = [0 1 1 1 0 0 -1 -1 -1 -1]; %z-direction translation

bearing = [0 10 20 30 20 10 0 -10 -20 -30]; %rotation

%%Perform the animation
for i = 1:length(latitude)
    
    translation = makehgtform('translate', [latitude(i), longitude(i), altitude(i)]);
    %set(combinedObject, 'matrix', translation);
    
    rotation1 = makehgtform('xrotate', (pi/180)*(bearing(i)));
    %set(combinedObject, 'matrix', rotation1);
    
    rotation2 = makehgtform('yrotate', (pi/180)*(bearing(i)));
    %set(combinedObject, 'matrix', rotation2);
    
    rotation3 = makehgtform('zrotate', (pi/180)*(bearing(i)));
    %set(combinedObject, 'matrix', rotation3);
    
    scaling = makehgtform('scale', 1-(i/20));
    %set(combinedObject, 'matrix', scaling);
    
    %The individual transformations can be combined
    set(combinedObject, 'matrix', translation*rotation1*rotation2*rotation3*scaling);
    
    pause(0.3)
end