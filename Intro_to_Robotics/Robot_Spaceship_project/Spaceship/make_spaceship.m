function [ myhandles ] = make_spaceship(trf_root, transparency)
% Makes a space-ship with the root transform as the given transform.
% The surfaces are drawn with the given transparency in [0,1]
% A vector of handles to all the surfaces is returned.

%% Body
ship_dish_profile= 2*sin(linspace(0, pi, 15));
[Xc, Yc, Zc]= cylinder(ship_dish_profile);

% Bottom dish
%hgtransform => Create transform object
%The transform object's Matrix property applies a transform to all the object’s children in unison. Transforms include rotation, translation, and scaling. Define a transform with a four-by-four transformation matrix.
trf_top_root= hgtransform('Parent', trf_root);
% makehgtform => Create 4-by-4 transform matrix
% M = makehgtform('translate',[tx ty tz]) or M = makehgtform('translate',tx,ty,tz) returns a transform that translates along the x-axis by tx, along the y-axis by ty, and along the z-axis by tz.
set(trf_top_root, 'Matrix', makehgtform('translate', [0, 0, -0.2]));

color_top= [    0.5098    0.5098    0.5098]; %Changed color
myhandles(1)= surface(Xc, Yc, Zc, 'Parent', trf_top_root, 'FaceColor', color_top, 'FaceAlpha', transparency, 'EdgeColor', 0.5*color_top, 'EdgeAlpha', transparency);

% Top dish
trf_bottom_root= hgtransform('Parent', trf_root);
set(trf_bottom_root, 'Matrix', makehgtform('translate', [0, 0, 0.2]));
color_bottom= [    0.2353    0.3137    0.4000]; %Changed color
%FaceAlpha is Face Transparency
%Edge is the edge lines for the specific object
myhandles(2)= surface(Xc, Yc, Zc, 'Parent', trf_bottom_root, 'FaceColor', color_bottom, 'FaceAlpha', transparency, 'EdgeColor', 0.5*color_bottom, 'EdgeAlpha', transparency);

%% Tails
% creates x, y, z coordinates of unit cylinder to draw left tail
[Xt, Yt, Zt]= cylinder([0.4 , 0.3 , 0]);

% Left tail
trf_tailleft_root= hgtransform('Parent', trf_root);
trf_scale= makehgtform('scale', [1,1,3]);
trf_Ry= makehgtform('yrotate', -pi/2);
trf_T_left= makehgtform('translate', [-3, 0.75, 2]);
% Interpret the order as BFT (left to right)
set(trf_tailleft_root, 'Matrix', trf_T_left*trf_Ry*trf_scale);
color_tail_left= [0 0.4 0.5]; 
myhandles(3)= surface(Xt, Yt, Zt, 'Parent', trf_tailleft_root, 'FaceColor', color_tail_left, 'FaceAlpha', transparency, 'EdgeColor', 0.5*color_tail_left, 'EdgeAlpha', transparency);

% Your code here. Use left tail as a reference and design spaceship as
% shown in the class. You can come up with a new design.

% Right tail
trf_tailright_root= hgtransform('Parent', trf_root);
trf_scale= makehgtform('scale', [1,1,3]);
trf_Ry= makehgtform('yrotate', -pi/2);
% Translate -0.75 to symmetric, and opposite to right tail
trf_T_right= makehgtform('translate', [-3, -0.75, 2]);
set(trf_tailright_root, 'Matrix', trf_T_right*trf_Ry*trf_scale);
color_tail_right= [0 0.4 0.5]; 
myhandles(4)= surface(Xt, Yt, Zt, 'Parent', trf_tailright_root, 'FaceColor', color_tail_right, 'FaceAlpha', transparency, 'EdgeColor', 0.5*color_tail_right, 'EdgeAlpha', transparency);

%% Engines
% Left tail engine
trf_leftEngine_root= hgtransform('Parent', trf_root);
% Made it smaller than the tail
trf_scale_Engines= makehgtform('scale', [0.9,0.9,0.5]);
set(trf_leftEngine_root, 'Matrix', trf_T_left*trf_Ry*trf_scale_Engines);
%Made Z-coordinate minus, so it would be in the other direction than the
%tail
myhandles(5)= surface(Xt, Yt, -Zt, 'Parent', trf_leftEngine_root, 'FaceColor', 'cyan', 'FaceAlpha', transparency, 'EdgeColor', 'cyan', 'EdgeAlpha', transparency);

% Right tail engine
trf_rightEngine_root= hgtransform('Parent', trf_root);
set(trf_rightEngine_root, 'Matrix', trf_T_right*trf_Ry*trf_scale_Engines);
myhandles(5)= surface(Xt, Yt, -Zt, 'Parent', trf_rightEngine_root, 'FaceColor', 'cyan', 'FaceAlpha', transparency, 'EdgeColor', 'cyan', 'EdgeAlpha', transparency);

%% Connecting tails
% Left connector 
trf_connectingLeft_root= hgtransform('Parent', trf_root);
trf_ConnectingScale= makehgtform('scale', [0.8,1,2.6]); %Made it shorter, and thinner than the tail
trf_ConnectRy= makehgtform('yrotate', -7);%Rotated it around y to a larger degree than the tail
trf_Connecting_left= makehgtform('translate', [-3, 0.75, 0]); %Did't translate it vertically
set(trf_connectingLeft_root, 'Matrix', trf_Connecting_left*trf_ConnectRy*trf_ConnectingScale);
myhandles(6)= surface(Xt, Yt, Zt, 'Parent', trf_connectingLeft_root, 'FaceColor', 'cyan', 'FaceAlpha', transparency, 'EdgeColor', 'cyan', 'EdgeAlpha', transparency);

% Right connector
trf_connectingRight_root= hgtransform('Parent', trf_root);
trf_Connecting_left= makehgtform('translate', [-3, -0.75, 0]); %Did't translate it vertically, and made it in the opposite direction from the left one
set(trf_connectingRight_root, 'Matrix', trf_Connecting_left*trf_ConnectRy*trf_ConnectingScale);%Used the same scaling and rotation as the left connector
myhandles(6)= surface(Xt, Yt, Zt, 'Parent', trf_connectingRight_root, 'FaceColor', 'cyan', 'FaceAlpha', transparency, 'EdgeColor', 'cyan', 'EdgeAlpha', transparency);


%% Bottom tails
% Bottom left tail

%Makes a cone with new dimentions 
[XBt, YBt, ZBt]= cylinder([0.34, 0.36 ,0.37, 0.38,0.43, 0.35, 0]); %(First normal radius, then bigger radius in the middle, then 0 to close the cone)
                                        

trf_BottomLeft_root= hgtransform('Parent', trf_root);
trf_BottomScale= makehgtform('scale', [0.8,1,4]);%Made the cone thinner and longer
trf_Bottom_left= makehgtform('translate', [0, 0.75, 0]);%Keep it on the origin, just move left
set(trf_BottomLeft_root, 'Matrix', trf_Bottom_left*trf_Ry*trf_BottomScale);
color_BottomTail= [0 0.4 0.5 ]; 
myhandles(7)= surface(XBt, YBt, ZBt, 'Parent', trf_BottomLeft_root, 'FaceColor', color_BottomTail, 'FaceAlpha', transparency, 'EdgeColor', color_BottomTail, 'EdgeAlpha', transparency);

% Bottom right tail
trf_BottomRight_root= hgtransform('Parent', trf_root);
trf_Bottom_right= makehgtform('translate', [0, -0.75, 0]);%Keep it on the origin, just move right
set(trf_BottomRight_root, 'Matrix', trf_Bottom_right*trf_Ry*trf_BottomScale); 
myhandles(8)= surface(XBt, YBt, ZBt, 'Parent', trf_BottomRight_root, 'FaceColor', color_BottomTail, 'FaceAlpha', transparency, 'EdgeColor', color_BottomTail, 'EdgeAlpha', transparency);

%% Cannon (Extra structure)
[Xa, Ya, Za]= cylinder([0.07 , 0.07 , 0.07]);
% cannon mount
trf_antenna_root= hgtransform('Parent', trf_root);
trf_scaleAntenna= makehgtform('scale', [1.5,1,1.3]);
%trf_Ry= makehgtform('yrotate', -pi/2);
trf_T_left= makehgtform('translate', [0, 1.05, 0]);
set(trf_antenna_root, 'Matrix', trf_T_left*trf_scaleAntenna);
 
myhandles(9)= surface(Xa, Ya, Za, 'Parent', trf_antenna_root, 'FaceColor', 'black', 'FaceAlpha', 0.5*transparency, 'EdgeColor', 'black', 'EdgeAlpha', 0.5*transparency);

% Gun1
[Xcan, Ycan, Zcan]= cylinder([0 , 0.1, 0.15 , 0.1]);

trf_cannon_root= hgtransform('Parent', trf_root);
trf_scaleCannon= makehgtform('scale', [0.9,0.9,1.2]);
trf_cannonRy= makehgtform('yrotate', pi/2);
trf_Can_left= makehgtform('translate', [-0.7, 1, 1.25]);
set(trf_cannon_root, 'Matrix', trf_Can_left*trf_cannonRy*trf_scaleCannon);
color_guns= [0.3412 0 0]; 

myhandles(10)= surface(Xcan, Ycan, Zcan, 'Parent', trf_cannon_root, 'FaceColor', color_guns, 'FaceAlpha', transparency, 'EdgeColor', color_guns, 'EdgeAlpha', transparency);

% Gun2
trf_cannon_root= hgtransform('Parent', trf_root);
trf_Can_right= makehgtform('translate', [-0.7, 1.1, 1.25]);
set(trf_cannon_root, 'Matrix', trf_Can_right*trf_cannonRy*trf_scaleCannon);
 
myhandles(11)= surface(Xcan, Ycan, Zcan, 'Parent', trf_cannon_root, 'FaceColor', color_guns, 'FaceAlpha', transparency, 'EdgeColor', color_guns, 'EdgeAlpha', transparency);
end

