create table users
(
    id         int(11) unsigned auto_increment primary key,
    nickname   varchar(32)  default '' not null comment '昵称',
    username   varchar(32)  default '' not null comment '用户名',
    password   varchar(256) default '' not null comment '密码',
    mobile     varchar(16)  default '' not null comment '电话',
    email      varchar(128) default '' not null comment '邮箱',
    avatar     varchar(128) default '' not null comment '头像',
    status     tinyint(1)   default 0  not null comment '状态0禁用1有效',
    remark     varchar(512) default '' not null comment '备注',
    is_del     tinyint(1)   default 0  not null comment '软删',
    created_at datetime                null,
    updated_at datetime                null,
    index idx_email (email),
    index idx_mobile (mobile),
    index idx_is_del_status (is_del, status),
    index idx_username (username)
) comment '用户列表';

create table resources
(
    id         int(11) unsigned auto_increment primary key,
    name       varchar(32)      default '' not null comment '名称',
    type       tinyint(4)       default 0  not null comment '类型',
    icon       varchar(128)     default '' not null comment '图标',
    is_default tinyint(1)       default 0  not null comment '默认开启',
    status     tinyint(1)       default 0  not null comment '状态0/1',
    p_id       int(11) unsigned default 0  not null comment '父级ID',
    sort       tinyint(4)       default 0  not null comment '顺序0~99',
    remark     varchar(256)     default '' not null comment '备注',
    is_del     tinyint(1)       default 0  not null comment '软删',
    created_at datetime                    null,
    updated_at datetime                    null,
    index idx_p_id (p_id),
    index idx_is_del_status (is_del, status)
) comment '资源列表';

create table departments
(
    id         tinyint(4) unsigned auto_increment primary key,
    name       varchar(32)         default '' not null comment '名称',
    leader_id  int(11) unsigned    default 0  not null comment '负责人ID',
    p_id       tinyint(4) unsigned default 0  not null comment '父级',
    status     tinyint(1) unsigned default 0  not null comment '状态:0禁用1启用',
    sort       tinyint(4)          default 0  not null comment '顺序0~99',
    remark     varchar(512)        default '' not null comment '备注',
    is_del     tinyint(1) unsigned default 0  not null comment '软删',
    created_at datetime                       null,
    updated_at datetime                       null,
    index idx_p_id (p_id),
    index idx_leader_id (leader_id),
    index idx_is_del_status (is_del, status)
) comment '部门列表';

create table department_resources
(
    id            int(11) unsigned    not null auto_increment primary key,
    department_id tinyint(4) unsigned not null default 0 comment '部门ID',
    resource_id   int(11) unsigned    not null default 0 comment '资源ID',
    is_del        tinyint(1) unsigned not null default 0 comment '软删',
    created_at    datetime            null,
    updated_at    datetime            null,
    index idx_dept_id_res_id (department_id, resource_id)
) comment '部门-资源关系';

create table department_users
(
    id            int(11) unsigned    not null auto_increment primary key,
    department_id tinyint(4) unsigned not null default 0 comment '部门ID',
    user_id       int(11) unsigned    not null default 0 comment '用户ID',
    is_del        tinyint(1) unsigned not null default 0 comment '软删',
    created_at    datetime            null,
    updated_at    datetime            null,
    index idx_dept_id_res_id (department_id, user_id)
) comment '部门-人员关系';
