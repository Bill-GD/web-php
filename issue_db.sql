create table if not exists `user` (
  user_id int auto_increment primary key,
  email varchar(100) not null unique,
  username varchar(50) not null unique,
  `password` varchar(32) not null, -- this is encrypted using md5
  avatar_url text not null,
  is_admin bool not null,
  date_created datetime not null,
  github_access_token text -- saved as hex
);

create table if not exists project (
  project_id int auto_increment primary key,
  project_name varchar(50) not null,
  `description` text not null,
  date_created datetime not null,
  `owner` int not null,
  foreign key (`owner`) references `user` (user_id) on delete cascade -- delete account -> delete all owned projects
);

create table if not exists project_role (
  project_id int not null,
  user_id int not null,
  user_role varchar(20) not null,
  primary key (project_id, user_id),
  foreign key (project_id) references project (project_id) on delete cascade, -- delete project -> delete all related roles
  foreign key (user_id) references `user` (user_id) on delete cascade -- delete related user -> delete role
);

create table if not exists issue (
  issue_id int auto_increment primary key,
  project_id int not null,
  title varchar(100) not null,
  `description` text not null,
  `status` varchar(10) not null, -- open, cancelled, pending, tested, closed
  priority varchar(5) not null, -- high, mid, low
  assignee int, -- user_id, null -> empty
  `issuer` int, -- user_id, null -> empty
  date_created datetime not null,
  date_updated datetime not null,
  foreign key (project_id) references project (project_id) on delete cascade, -- delete all issues of project
  foreign key (assignee) references `user` (user_id) on delete set null, -- set null to deleted user
  foreign key (`issuer`) references `user` (user_id) on delete set null -- set null to deleted user
);

create table if not exists issue_image (
  image_id int primary key,
  issue_id int not null,
  bytes text not null, -- should be hex, continuous
  foreign key (issue_id) references issue (issue_id) on delete cascade -- delete if issue is deleted
);

/* sql-formatter-disable */
delimiter $$
-- use this instead of 'delete from ...'
create procedure delete_user (in user_id_delete int)
begin
  delete from `user` where user_id = user_id_delete;
  call reset_user_id();
end $$
delimiter ;

delimiter $$
create procedure reset_user_id ()
begin
  select coalesce(max(user_id), 0) + 1 from `user` into @next_id;
  
  set @alter_statement = concat('alter table `user` auto_increment = ', @next_id);
  PREPARE stmt FROM @alter_statement;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
end $$
delimiter ;

delimiter $$
-- use this instead of 'delete from...'
create procedure delete_project (in project_id_delete int)
begin
  delete from project where project_id = project_id_delete;
  call reset_project_id();
end $$
delimiter ;

delimiter $$
create procedure reset_project_id ()
begin
  select coalesce(max(project_id), 0) + 1 from `project` into @next_id;
  
  set @alter_statement = concat('alter table project auto_increment = ', @next_id);
  PREPARE stmt FROM @alter_statement;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
end $$
delimiter ;
/* sql-formatter-enable */