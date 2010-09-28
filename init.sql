create table comics_date (
  comic         varchar(20)     not null,
  date          date            not null,
  gfx           tinytext        null,
  comment       text            null,
  timestamp     datetime        not null,
  primary key (comic,date)
);
