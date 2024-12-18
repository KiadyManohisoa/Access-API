

psql -U username -h dpg-ct4lrf56l47c73f9su10-a.frankfurt-postgres.render.com -p 5432 -U admin -d relevesnotes -f backup.sql

-- psql -U symfony -h localhost -p 5433 -d relevesnotes -f backup.sql

-- PGPASSWORD=M3BRFaAhZM4vALXtPfMFDVVAEmQ6Dh0r psql -h dpg-ct4lrf56l47c73f9su10-a.frankfurt-postgres.render.com -U admin relevesnotes