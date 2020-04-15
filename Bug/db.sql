create table Reports (
  id int unsigned not null auto_increment primary key,
  product varchar(50) not null,
  version varchar(20) not null,
  os varchar(25) not null,
  btype varchar(25) not null,
  summary varchar(255),
  status enum('Documenting', 'Verified', 'QA Testing','In progress'),
  reported varchar(100),
  entered date not null
);
  
insert into Reports values
(null, 'MySQL', '5.0', 'Microsoft Windows', 'Server: Installing', 'Multiple Uninstallation Entries in Add/Remove Programs', 'Documenting', 'Iggy Galarza', '2004-06-19'),
(null, 'MySQL', 'all', 'all', 'Connector/ODBC', 'Function CONVERT ODBC database independent types not translated', 'Verified', '', '2005-01-13'),
(null, 'MySQL', '5.0', 'all', 'Server: Charsets', 'Incorrect conversion results of arithmetic operation to ucs2 string', 'Verified', 'Alexander Barkov', '2005-01-30'),
(null, 'MySQL', '5.0.3-alpha-debug', 'Linux (SuSE 9.1)', 'Server: DML', 'Overflow must be an error', 'Verified', 'Alexey Kopytov', '2005-02-11'),
(null, 'MySQL', '6.0-beta', 'Linux (SuSE 9.1)', 'Server: DML', 'SQRT: Should return an error when argument is negative', 'In progress', 'Evgeny Potemkin', '2009-02-13');
