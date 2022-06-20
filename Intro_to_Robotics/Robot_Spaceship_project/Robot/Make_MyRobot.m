clear all
close all
clf
%% Set the axis and the camera view
handle_axes= axes('XLim', [-0.4,0.4], 'YLim', [-0.2,0.4], 'ZLim', [0,0.4]);

xlabel('e_1'); 
ylabel('e_2');
zlabel('e_3');

view(-130, 26);
grid on;
axis equal
camlight
axis_length= 0.05;

%% Root frame E
trf_E_axes= hgtransform('Parent', handle_axes); 

%% Link-0: Base-link

trf_link0_E= make_transform([0, 0, 0], 0, 0, pi/2, trf_E_axes);
plot_axes(trf_link0_E, 'L_0', false, axis_length); 

trf_viz_link0= make_transform([0, 0, 0.1], 0, 0, 0, trf_link0_E);
length0= 0.2; radius0= 0.05;
h(1)= link_cylinder(radius0, length0, trf_viz_link0, [0.5 0.52 0.49]); % Changed color
plot_axes(trf_viz_link0, ' ', true, axis_length); 

%% Link-1
trf_viz_link1= make_transform([0.1, 0, 0], 0, 0, 0); % Do not specify parent yet: It will be done in the joint
h(2)= link_box([0.2, 0.02, 0.02], trf_viz_link1, [0, 0, 1]); 
plot_axes(trf_viz_link1, ' ', true, axis_length); 


%% Link-2
trf_viz_link2= make_transform([0.1, 0, 0], 0, 0, 0); % Do not specify parent yet: It will be done in the joint
h(3)= link_box([0.2, 0.01, 0.01], trf_viz_link2, [0, 0.5, 0.5]); % Changed color and sides position (dimentions)
plot_axes(trf_viz_link2, ' ', true, axis_length); 

%% Link-3
trf_viz_link3= make_transform([0, 0, 0], 0, 0, 0); % Do not specify parent yet: It will be done in the joint
h(7)= link_sphere(0.012, trf_viz_link3, [0.4941 0.1843 0.5569]); 
% plot_axes(trf_viz_link3, ' ', true, axis_length); % V_3



%% Joint 1: Links 0,1: Revolute
j1_rot_axis_j1= [0,0,1]';
j1_rot_angle= 0; % [-pi/2, pi/2]

trf_joint1_link0= make_transform([0, 0, 0.21], 0, 0, 0, trf_link0_E); 
trf_link1_joint1= make_transform_revolute(j1_rot_axis_j1, j1_rot_angle, trf_joint1_link0); 
plot_axes(trf_link1_joint1, 'L_1', false, axis_length); 
make_child(trf_link1_joint1, trf_viz_link1);

%% Joint 2: Links 1,2: Revolute
j2_rot_axis_j2= [0,0,1]';
j2_rot_angle= 0; 

trf_joint2_link1= make_transform([0.2, 0, 0.015], 0, 0, 0 , trf_link1_joint1); 
trf_link2_joint2= make_transform_prismatic(j2_rot_axis_j2, j2_rot_angle, trf_joint2_link1); 
plot_axes(trf_link2_joint2, 'L_2', false, axis_length); 
make_child(trf_link2_joint2, trf_viz_link2);

%% Joint: Links 2,3: Fixed
trf_link3_link2= make_transform([0.2, 0, 0], 0, 0, 0, trf_link2_joint2); 
make_child(trf_link3_link2, trf_viz_link3);

%% Animation: One joint at a time
for q1=[linspace(0, -pi/2, 30), linspace(-pi/2, pi/2, 30), linspace(pi/2, 0, 30)]
    set(handle_axes, 'XLim', [-0.4,0.4], 'YLim', [-0.2,0.4], 'ZLim', [0,0.4]);
    trf_q1= makehgtform('axisrotate', j1_rot_axis_j1, q1);%M = makehgtform('axisrotate',[ax,ay,az],t) Rotate around axis [ax ay az] by t radians.
    set(trf_link1_joint1, 'Matrix', trf_q1);
    drawnow;
    pause(0.02);
end

for q2=[linspace(0, -pi/2, 30), linspace(-pi/2, pi/2, 30), linspace(pi/2, 0, 30)]
    set(handle_axes, 'XLim', [-0.4,0.4], 'YLim', [-0.2,0.4], 'ZLim', [0,0.4]);
    trf_q2= makehgtform('axisrotate', j2_rot_axis_j2, q2);
    set(trf_link2_joint2, 'Matrix', trf_q2);
    drawnow;
    pause(0.02);
end

%% Animation: All joints together.
q_init= 0.5*ones(4,1); % This leads to all joints being at 0.

for i= 1:20
    q_next= rand(4,1); 
    % rand() gives uniformly distributed random numbers in the interval [0,1]
    
    for t=0:0.02:1
        q= q_init + t*(q_next - q_init);
        q1= (pi/2)*(2*q(1) - 1);
        q2= (pi/2)*(2*q(2) - 1);
        q3= (pi/2)*(2*q(3) - 1);
        a4= (0.04)*(2*q(4) - 1);
        
        set(handle_axes, 'XLim', [-0.4,0.4], 'YLim', [-0.2,0.4], 'ZLim', [0,0.4]);
        trf_q1= makehgtform('axisrotate', j1_rot_axis_j1, q1);
        set(trf_link1_joint1, 'Matrix', trf_q1);
        
        set(handle_axes, 'XLim', [-0.4,0.4], 'YLim', [-0.2,0.4], 'ZLim', [0,0.4]);
        trf_q2= makehgtform('axisrotate', j2_rot_axis_j2, q2);
        set(trf_link2_joint2, 'Matrix', trf_q2);
        drawnow;
        pause(0.005);
        
    end
    
    q_init= q_next;
    
end
