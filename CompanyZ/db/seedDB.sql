use mydb;
-- filling  x tables
insert into Xparts543
    value( "p1", "wrench", "wrenches", 3.85, 60);

insert into Xparts543
    value( "p2", "beam", "Steal beam", 15, 90);

insert into Xparts543
    value( "p3", "screw", "long screw", 1, 300);

insert into Xclients543
    value( "c1", "Alex", "Halifax", "password", 0.0, "ready");
insert into Xclients543
    value( "c2", "Dal", "Halifax", "password", 0.0, "ready");
insert into Xclients543
    value( "c3", "MIT", "Boston", "password", 0.0, "ready");
insert into Xclients543
    value( "c7", "Z", "Company", "password", 0.0, "ready");



-- doing Orders
insert into Xpos543
values("po1", curdate(), "processing", "c1");
insert into Xpos543
values("po2", curdate(), "processing", "c3");



insert into Xlines543
values("p1","l1","po1", NULL, 20);
insert into Xlines543
values("p2","l2","po1", NULL, 2);
insert into Xlines543
values("p3","l3","po1", NULL, 4);
insert into Xlines543
values("p2","l2","po2", NULL, 2);



-- selecting all tables
select * from Xclients543;
select * from Xpos543;
select * from Xparts543;
select * from Xlines543;


-- filling  Y tables
insert into Yparts543
    value( "p4", "saw", "cuts stuff", 5, 80);

insert into Yparts543
    value( "p2", "beam", "Steal beam", 10, 75);

insert into Yparts543
    value( "p5", "glass", "clear glass", 20, 300);

insert into Yclients543
    value( "c4", "Dan", "Halifax", "password", 0.0, "ready");
insert into Yclients543
    value( "c5", "SMU", "Halifax", "password", 0.0, "ready");
insert into Yclients543
    value( "c6", "BC", "Boston", "password", 0.0, "ready");
insert into Yclients543
    value( "c7", "Z", "Company", "password", 0.0, "ready");



-- doing Orders
insert into Ypos543
values("po1", curdate(), "processing", "c4");
insert into Ypos543
values("po2", curdate(), "processing", "c7");




insert into Ylines543
values("p4","l1","po1", NULL, 20);
insert into Ylines543
values("p5","l3","po1", NULL, 4);
insert into Ylines543
values("p4","l3","po2", NULL, 20);
insert into Ylines543
values("p5","l1","po2", NULL, 4);



-- selecting all tables
select * from Yclients543;
select * from Ypos543;
select * from Yparts543;
select * from Ylines543;



-- seeding Z


insert into Zclients543
    value( "c4", "Dan", "Halifax", "password", 0.0, "ready");
insert into Zclients543
    value( "c1", "Alex", "Halifax", "password", 0.0, "ready");



-- doing Orders
insert into Zpos543
values("po1", curdate(), "processing", "c4");



insert into Zlines543
values("p4","l1","po1", "Y", "po2", 5.0, 20);
insert into Zlines543
values("p5","l2","po1", "Y", "po2", 20.0, 4);
