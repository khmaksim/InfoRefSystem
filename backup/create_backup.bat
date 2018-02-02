start "" "C:\Program Files\PostgreSQL\9.6\bin\pg_dump.exe" -U postgres -d isys-db -f "C:\Apache24\htdocs\isszgt\backup\%DATE:~6,4%%DATE:~3,2%%DATE:~0,2%_%TIME:~0,2%%TIME:~3,2%%TIME:~6,2%.backup"
pause