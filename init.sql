create table comics_date (
  comic         varchar(20)     not null,
  date          datetime        not null,
  gfx           tinytext        not null,
  primary key (comic,date)
);
