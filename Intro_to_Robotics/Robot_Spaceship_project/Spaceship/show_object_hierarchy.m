% Shows the initial and final pose of a space-ship which undergoes
% roll-pitch-yaw and translation.
clear all
clf
handle_axes= axes('XLim', [-4, 4], 'YLim', [-4, 4], 'ZLim', [-4, 4]);
xlabel('e_1');
ylabel('e_2');
zlabel('e_3');

view(3);
grid on;
axis equal
camlight

% Create ship-1
trf_ship1_root= hgtransform('Parent', handle_axes);
%Parent, specified as an Axes, Group, or Transform object.
h_original_ship= make_spaceship(trf_ship1_root, 0.8);

% Create ship-2 translated and rotated w.r.t. ship-1
trf_ship2_ship1= hgtransform('Parent',trf_ship1_root);
h_ship2= make_spaceship(trf_ship2_ship1, 0.8);

roll= -pi/10;
pitch= pi/8;
yaw= pi;

trf_roll= makehgtform('xrotate', roll);
trf_pitch= makehgtform('yrotate', pitch);
trf_yaw= makehgtform('zrotate', yaw);



trf_rpy= trf_yaw*trf_pitch*trf_roll;

translation= [3,2,3]; % 4,2,2
trf_translate= makehgtform('translate', translation);
trf_final= trf_translate*trf_rpy;

set(trf_ship2_ship1, 'Matrix', trf_final);
drawnow;

%% Motion coordinates
longitude = 0:19; %x-direction translation
latitude = [0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0]; %y-direction translation
altitude = [0 3 2 1 1 3 4 4 5 5 3 3 1 0 2 4 3 3 4 4 3]; %z-direction translation
bearing = [0 7 9 3 -5 -7 -9 -3 3 6 9 5 0 -3 -5 -3 -1 3 4 3]; %rotation

%% Perform the animation
for i = 1:length(longitude)
    
    translation = makehgtform('translate', [longitude(i),latitude(i),altitude(i)]);
    rotation1 = makehgtform('xrotate', (pi/180)*(bearing(i)));
    rotation2 = makehgtform('yrotate', (pi/180)*(bearing(i)));
    rotation3 = makehgtform('zrotate', (pi/180)*(bearing(i)));
    set(trf_ship1_root, 'matrix', translation*rotation1*rotation2*rotation3);
    
    
    pause(0.2)

end
