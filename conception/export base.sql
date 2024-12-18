pg_dump -U postgres -h localhost -p 5432 relevesnotes > backup.sql

-- Encodage avec utf-8 pour les caracteres spéciaux
pg_dump -U postgres -h localhost -p 5432 -d relevesnotes --encoding=UTF8 > backup.sql
